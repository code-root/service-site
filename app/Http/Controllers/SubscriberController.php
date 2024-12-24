<?php

namespace App\Http\Controllers;

use App\Models\App\DeviceUser;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;
use App\Models\Subscriber;
use Browser;
class SubscriberController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ]);

        Subscriber::create([
            'email' => $request->email,
        ]);

        return response()->json(['message' => 'تم الاشتراك بنجاح!']);
    }


    public function subscribe(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:service_orders,email,NULL,id,service_id,' . $request->service_id,
            'phone' => 'required|string|max:20|unique:service_orders,phone,NULL,id,service_id,' . $request->service_id,
            'message' => 'nullable|string',
            'service_id' => 'required|exists:services,id',
        ]);

        $deviceData = $this->getDeviceData($request);
        $deviceId = $this->getDeviceToken($deviceData);
        if (!$deviceId) {
            $device = DeviceUser::create($deviceData);
            $deviceId = $device->id;
        }
        $deviceToken = sha1(json_encode($deviceData));

        $o = ServiceOrder::create([
            'service_id' => $request->service_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'serial' => $deviceToken,
            'message' => $request->message,
            'ip_address' => $request->ip(),
        ]);

        deviceUser::where('id', $deviceId)->update(['order_id' => $o->id]);
        return response()->json(['message' => 'Subscription successful.']);
    }
    public static function getDeviceData($request)
    {
        return [
            'service_id' => $request->service_id,
            'order_id' => 0,
            'device_type' => Browser::deviceType(),
            'device_name' => Browser::deviceModel(),
            'device_os' => Browser::platformName(),
            'device_version' => Browser::platformVersion(),
            'device_browser' => Browser::browserName(),
            'device_browser_version' => Browser::browserVersion(),
            'device_ip' => $request->ip(),
            'is_mobile' => Browser::isMobile(),
            'is_tablet' => Browser::isTablet(),
            'is_desktop' => Browser::isDesktop(),
            'is_bot' => Browser::isBot(),
        ];
    }


    public function storeToken(Request $request) {

        $deviceData = $this->getDeviceData($request);
        $deviceId = $this->getDeviceToken($deviceData);
        if (!$deviceId) {
            $device = DeviceUser::create($deviceData);

            $deviceId = $device->id;
        }
    }


    public function getDeviceToken(array $deviceData) {
        $deviceToken = sha1(json_encode($deviceData));
        $device = DeviceUser::where('device_token', $deviceToken)->first();
        if ($device) {
        return $device->id;
        }
        return null;
    }

    public function order(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'nullable|string',
            'service_id' => 'required|exists:services,id',
            'ip_address' => 'required|ip',
        ]);

        $order = ServiceOrder::create($request->all());

        return redirect()->back()->with('success', 'Order submitted successfully.');
    }

}
