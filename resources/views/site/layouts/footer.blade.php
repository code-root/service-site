<footer class="amazing-footer footer-dark bg-image footer-style-3">
    <div class="footer-top">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <div class="amazing-footer-widget">
                        <div class="logo">
                            <a href="/">
                                <img class="logo-light"
                                    src="{{ route('view-image', ['m' => 'Setting', 'id' => 0, 'nameVar' => 'logo']) }}"
                                    alt="Corporate Logo">
                            </a>
                        </div>
                        <p class="description">{{ $basicFields['footer_description'] ?? 'Default footer description' }}</p>
                        <div class="widget-information">
                            <ul class="information-list">
                                <li><span>Call:</span><a
                                        href="tel:{{ $basicFields['phone'] ?? '+01 123 5641 231' }}">{{ $basicFields['phone'] ?? '+01 123 5641 231' }}</a>
                                </li>
                                <li><span>Email:</span><a
                                        href="mailto:{{ $basicFields['email'] ?? 'info@al-amazing-.com' }}"
                                        target="_blank">{{ $basicFields['email'] ?? 'info@al-amazing-.com' }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="amazing-footer-widget">
                        <h4 class="widget-title">{{ session('locale') === 'ar' ? 'الصفحات' : 'Pages' }}</h4>
                        <div class="inner">
                            <ul class="footer-link link-hover">
                                <li><a
                                        href="{{ url('/contact') }}">{{ $locale === 'ar' ? 'تواصل معنا' : 'Contact Us' }}</a>
                                </li>
                                    @forelse ($pages as $page)
                                    <li><a
                                            href="{{ route('page.show', $page->id) }}">{{ $page->{'name_' . $locale} }}</a>
                                    </li>
                                @empty
                                    <li><a href="#">No pages found</a></li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="amazing-footer-widget">
                        <h4 class="widget-title">Contacts</h4>
                        <div class="inner">
                            <p class="description">Enter your email address to register to our newsletter subscription
                            </p>
                            <div class="input-group footer-subscription-form">
                                <input type="email" class="form-control" id="subscriber-email"
                                    placeholder="Your email" required>
                                <button class="amazing-btn btn-secondary btn-medium" id="subscribe-button"
                                    type="button">Subscribe <i class="icon-4"></i></button>
                            </div>

                            <ul class="social-share icon-transparent">
                                @if (!empty($basicFields['facebook']))
                                    <li><a href="{{ $basicFields['facebook'] }}" class="color-fb"><i
                                                class="fab fa-facebook-f"></i></a></li>
                                @endif
                                @if (!empty($basicFields['twitter']))
                                    <li><a href="{{ $basicFields['twitter'] }}" class="color-twitter"><i
                                                class="fab fa-twitter"></i></a></li>
                                @endif
                                @if (!empty($basicFields['instagram']))
                                    <li><a href="{{ $basicFields['instagram'] }}" class="color-ig"><i
                                                class="fab fa-instagram"></i></a></li>
                                @endif
                                @if (!empty($basicFields['linkedin']))
                                    <li><a href="{{ $basicFields['linkedin'] }}" class="color-linkd"><i
                                                class="fab fa-linkedin-in"></i></a></li>
                                @endif
                                @if (!empty($basicFields['youtube']))
                                    <li><a href="{{ $basicFields['youtube'] }}" class="color-yt"><i
                                                class="fab fa-youtube"></i></a></li>
                                @endif
                                @if (!empty($basicFields['snapchat']))
                                    <li><a href="{{ $basicFields['snapchat'] }}" class="color-snapchat"><img
                                                alt="svgImg"
                                                src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iMzAiIGhlaWdodD0iMzAiIHZpZXdCb3g9IjAgMCAzMCAzMCI+CjxwYXRoIGZpbGw9IiNmZmVlYTMiIGQ9Ik03Ljg1NywyNy41Yy0yLjk1NCwwLTUuMzU3LTIuNDAzLTUuMzU3LTUuMzU3VjcuODU3QzIuNSw0LjkwMyw0LjkwMywyLjUsNy44NTcsMi41aDE0LjI4NiBjMi45NTQsMCw1LjM1NywyLjQwMyw1LjM1Nyw1LjM1N3YxNC4yODZjMCwyLjk1NC0yLjQwMyw1LjM1Ny01LjM1Nyw1LjM1N0g3Ljg1N3oiPjwvcGF0aD48cGF0aCBmaWxsPSIjYmE5YjQ4IiBkPSJNMjIuMTQzLDI4SDcuODU3QzQuNjI4LDI4LDIsMjUuMzczLDIsMjIuMTQzVjcuODU3QzIsNC42MjcsNC42MjgsMiw3Ljg1NywyaDE0LjI4NSBDMjUuMzcyLDIsMjgsNC42MjcsMjgsNy44NTd2MTQuMjg2QzI4LDI1LjM3MywyNS4zNzIsMjgsMjIuMTQzLDI4eiBNNy44NTcsM0M1LjE3OSwzLDMsNS4xNzksMyw3Ljg1N3YxNC4yODYgQzMsMjQuODIxLDUuMTc5LDI3LDcuODU3LDI3aDE0LjI4NUMyNC44MjEsMjcsMjcsMjQuODIxLDI3LDIyLjE0M1Y3Ljg1N0MyNyw1LjE3OSwyNC44MjEsMywyMi4xNDMsM0g3Ljg1N3oiPjwvcGF0aD48Zz48cGF0aCBmaWxsPSIjZmZmMWU4IiBkPSJNMTQuOTU5LDIzLjVjLTAuMDQ4LDAtMC4wOTYsMC0wLjE0NCwwYy0wLjA0OCwwLTAuMDQ4LDAtMC4wOTYsMGMtMS4xMDQsMC0xLjY3LTAuMzM4LTIuMzQyLTAuODE4IGMtMC40OC0wLjMzNi0wLjkxMi0wLjYyNC0xLjM5My0wLjcyYy0wLjI0LTAuMDQ4LTAuNDgtMC4wNDgtMC43NjgtMC4wNDhjLTAuNDMyLDAtMC43NjgsMC4wNDgtMS4wMDgsMC4wOTYgYy0wLjE0NCwwLjA0OC0wLjI4OCwwLjA0OC0wLjM4NCwwLjA0OGMtMC4wOTYsMC0wLjI0LDAtMC4yODgtMC4xOTJjLTAuMDQ4LTAuMTQ0LTAuMDk2LTAuMjg4LTAuMDk2LTAuNDMyIGMtMC4wOTYtMC4zMzYtMC4xNDQtMC41NzYtMC4yODgtMC41NzZjLTEuNzI5LTAuMjg4LTIuMjA5LTAuNjI0LTIuMzA1LTAuODY0YzAtMC4wNDgsMC0wLjA0OCwwLTAuMDk2IGMwLTAuMDk2LDAuMDQ4LTAuMTkyLDAuMTQ0LTAuMTkyYzIuNjQxLTAuNDMyLDMuNzkzLTMuMTIxLDMuODg5LTMuMjY1bDAsMGMwLjE0NC0wLjMzNiwwLjE5Mi0wLjYyNCwwLjA5Ni0wLjg2NCBjLTAuMTkyLTAuNDMyLTAuNzY4LTAuNDUzLTEuMTUyLTAuNTQ5Yy0wLjA5Ni0wLjA0OC0wLjE5Mi0wLjA0OC0wLjI0LTAuMDk2Yy0wLjgxNi0wLjI4OC0wLjcyMy0wLjYyNC0wLjcyMy0wLjc2OCBjMC4wNDgtMC4yODgsMC4yOTEtMC40OCwwLjU3OS0wLjQ4YzAuMDk2LDAsMC4yOTMsMC4wMywwLjM1OCwwLjA0OGMwLjQ1MywwLjEyNiwwLjUwNiwwLjA2OSwwLjc5NCwwLjA2OSBjMC4zODQsMCwwLjk0LTAuNDUxLDAuOTg4LTAuNDk5YzAtMC4xOTIsMC4wNDgtMC4wODMsMC0wLjI3NWMtMC4wOTYtMS4yNDgtMC4wNjgtMy4wOTEsMC4xNzUtMy43MSBjMS4yLTIuNjQxLDMuMzAzLTIuODE1LDQuMDIzLTIuODE1aDAuMzM2aDAuMDQ4YzAuNzIsMCwyLjg4NSwwLjE5Miw0LjAzNywyLjgzM2MwLjM4NCwwLjg2NCwwLjI2OSwyLjQ0OSwwLjIyMSwzLjY5N2wwLjA2MywwLjA0OCBjMCwwLjE5Mi0wLjAyNywwLjA0Ni0wLjA2MywwLjIyMmMwLDAsMC41NDMsMC40MDMsMC44OCwwLjQ1MWMwLjI0LDAsMC41NDksMC4wMTksMC44NjQtMC4wNDdjMC4yMzMtMC4wNDksMC41MjgtMC4wNDgsMC42MjQsMCBsMC4wOTksMC4wMzljMC4yODgsMC4wOTYsMC4yNTMsMC4yNDksMC4yNTMsMC40NDFjMCwwLjE5Mi0wLjA2NCwwLjQ4LTAuNzM2LDAuNzJjLTAuMDQ4LDAuMDQ4LTAuMTQ0LDAuMDQ4LTAuMjQsMC4wOTYgYy0wLjM4NCwwLjE0NC0wLjk2LDAuMDk1LTEuMTUyLDAuNTI3Yy0wLjA5NiwwLjI0LTAuMDQ4LDAuNTI4LDAuMDk2LDAuODY0bDAsMGMwLjA0OCwwLjA5NiwxLjI0OCwyLjc4NSwzLjg4OSwzLjI2NSBjMC4wOTYsMCwwLjE5MiwwLjA5NiwwLjE0NCwwLjE5MmMwLDAuMDQ4LDAsMC4wOTYtMC4wNDgsMC4wOTZjLTAuMDk2LDAuMjQtMC41NzYsMC42MjQtMi4zMDUsMC44NjQgYy0wLjE0NCwwLTAuMTkyLDAuMTkyLTAuMjg4LDAuNTc2Yy0wLjA0OCwwLjE0NC0wLjA0OCwwLjI4OC0wLjA5NiwwLjQzMmMtMC4wNDgsMC4xNDQtMC4wOTYsMC4xOTItMC4yNCwwLjE5MmwwLDAgYy0wLjA5NiwwLTAuMjQsMC0wLjM4NC0wLjA0OGMtMC4yODgtMC4wNDgtMC42MjQtMC4wOTYtMS4wMDgtMC4wOTZjLTAuMjQsMC0wLjQ4LDAtMC43MiwwLjA0OGMtMC41MjgsMC4wOTYtMC45NiwwLjM4NC0xLjM5MywwLjcyIEMxNi44NDIsMjMuMTYyLDE2LjA2MywyMy41LDE0Ljk1OSwyMy41eiI+PC9wYXRoPjxwYXRoIGZpbGw9IiNhMTZhNGEiIGQ9Ik0xNC45NTksMjRoLTAuMTQ1Yy0xLjM1MSwwLTIuMDMtMC40MTMtMi43MjktMC45MTFjLTAuNDQ4LTAuMzEzLTAuODI0LTAuNTYyLTEuMi0wLjYzNyBjLTAuNDItMC4wODQtMS4wNDktMC4wNTgtMS41ODEsMC4wNDhjLTAuMTU5LDAuMDU4LTAuMzY5LDAuMDU4LTAuNDgxLDAuMDU4Yy0wLjU2OSwwLTAuNzMtMC40LTAuNzczLTAuNTcyIGMtMC4wNC0wLjExOC0wLjA5Ni0wLjI4My0wLjEwNy0wLjQ3NWwtMC4wMTgtMC4wNTljLTAuMDE0LTAuMDUxLTAuMDI1LTAuMDk4LTAuMDM4LTAuMTRjLTEuNTY0LTAuMjc2LTIuMjk4LTAuNjE4LTIuNTA1LTEuMTMzIGwtMC4wMzYtMC4xODdjMC0wLjQ4NCwwLjI4My0wLjc4OCwwLjY0NS0wLjc4OGMxLjMzMi0wLjIyNSwyLjUzNC0xLjIzLDMuMzk1LTIuOWMwLjAzOS0wLjA3NSwwLjA2Ni0wLjEyNCwwLjA4LTAuMTQ0IGMwLjA1LTAuMTM5LDAuMDgyLTAuMzExLDAuMDQ2LTAuNDAxYy0wLjA0Mi0wLjA5NS0wLjMyMy0wLjE0OS0wLjU0OS0wLjE5M2MtMC4wOTItMC4wMTgtMC4xOC0wLjAzNS0wLjI2LTAuMDU2TDguNiwxNS40NzQgYy0wLjA3Ny0wLjAyMS0wLjE2My0wLjA0NS0wLjI0OC0wLjA5NWMtMC43MDQtMC4yNjQtMS4wMi0wLjY0Ni0wLjk5Mi0xLjJjMC4wOTQtMC42MTksMC41NDUtMC45OTYsMS4wOC0wLjk5NiBjMC4xNCwwLDAuMzg0LDAuMDM2LDAuNDkxLDAuMDY2YzAuMjAyLDAuMDU2LDAuMjg2LDAuMDYzLDAuMzQxLDAuMDYzbDAuMTAyLTAuMDA0YzAuMDYzLTAuMDA0LDAuMTMyLTAuMDA4LDAuMjE5LTAuMDA4IGMwLjA5Ni0wLjAwMSwwLjMxOC0wLjEyNCwwLjQ4OS0wLjI0MmMtMC4wODQtMS4xMDItMC4xMDItMy4xMzYsMC4yMDgtMy45MjRDMTEuNTc0LDYuMzAzLDEzLjg1NSw2LDE0Ljc3Nyw2aDAuMzM2IGMwLjk4OSwwLDMuMzExLDAuMzA1LDQuNTQ0LDMuMTM0YzAuMzkyLDAuODgsMC4zMzEsMi4yODcsMC4yNzgsMy41MjhsLTAuMDA3LDAuMTYzbDAuMDU0LDAuMjQ5IGMwLjE1NywwLjA5NCwwLjMxMywwLjE3MiwwLjM4OSwwLjE4M2wwLjA2Ny0wLjAwM2wwLjE0OCwwLjAwMWMwLjE0MywwLDAuMzExLTAuMDA0LDAuNDc1LTAuMDM5YzAuMTQ1LTAuMDMsMC4zMS0wLjA0NywwLjQ2NS0wLjA0NyBjMC4yNzYsMCwwLjQxLDAuMDUyLDAuNDg3LDAuMDlsMC4wNTgsMC4wMjFjMC41ODEsMC4xOTMsMC41NzIsMC42NzcsMC41NjksMC44NThjLTAuMDAxLDAuNTc0LTAuMzI4LDAuOTU4LTEuMDAxLDEuMjE0IGMtMC4wODMsMC4wNS0wLjE2NCwwLjA3My0wLjIxOSwwLjA4OGMtMC4yMTgsMC4wODEtMC4zNzMsMC4xMTUtMC41MzIsMC4xNDZjLTAuMTc0LDAuMDM0LTAuMzksMC4wNzctMC40MiwwLjE0NiBjLTAuMDE0LDAuMDM1LTAuMDI5LDAuMTY2LDAuMDk5LDAuNDY1YzAuMjAxLDAuNDIzLDEuMzIsMi41NywzLjUyLDIuOTdjMC4xNDYtMC4wMTMsMC4zNTUsMC4xMTMsMC40NzUsMC4zMDcgYzAuMDg5LDAuMTQ1LDAuMTEzLDAuMzE0LDAuMDc0LDAuNDczYy0wLjAxOSwwLjE2MS0wLjA4MywwLjI3My0wLjE2NSwwLjM1MWMtMC4zMDcsMC40NjMtMS4wODksMC43NzgtMi40MjcsMC45ODIgYy0wLjAxOSwwLjA2OS0wLjA0LDAuMTU0LTAuMDU5LDAuMjI5Yy0wLjAyNiwwLjA4My0wLjAzMiwwLjEzMS0wLjA0LDAuMTc3Yy0wLjAxNiwwLjA5OC0wLjAzNCwwLjE5NC0wLjA2NiwwLjI5MiBjLTAuMTE4LDAuMzU0LTAuMzU4LDAuNTM0LTAuNzE1LDAuNTM0Yy0wLjExMiwwLTAuMzIxLDAtMC41NDItMC4wNzRjLTAuMzM3LTAuMDQ2LTAuOTg4LTAuMTI5LTEuNDczLTAuMDMyIGMtMC40MTQsMC4wNzUtMC43NzEsMC4zMDQtMS4xODUsMC42MjVDMTcuMTcxLDIzLjU0NSwxNi4yODUsMjQsMTQuOTU5LDI0eiBNMTAuMjE2LDIxLjQxNGMwLjMxLDAsMC41NzcsMCwwLjg2NiwwLjA1OCBjMC41NjUsMC4xMTMsMS4wNTEsMC40MywxLjU4MSwwLjgwMUMxMy4yOCwyMi43MTMsMTMuNzU0LDIzLDE0LjcxOSwyM2gwLjI0YzEuMDA4LDAsMS42OTktMC4zMTQsMi40MjgtMC43ODYgYzAuNDIyLTAuMzMxLDAuOTM0LTAuNjc2LDEuNTc1LTAuNzkyYzAuNzIyLTAuMTQ0LDEuMzczLTAuMDQsMS45LDAuMDQ3YzAuMDM3LDAuMDExLDAuMDcsMC4wMTksMC4xMDIsMC4wMjQgYzAuMDE1LTAuMDg4LDAuMDMyLTAuMTc3LDAuMDYyLTAuMjY1YzAuMTAxLTAuNDExLDAuMjI4LTAuOTE4LDAuNzYzLTAuOTE4YzAuNzM5LTAuMTA1LDEuMTktMC4yMzUsMS40NjItMC4zNDQgYy0yLjI2My0wLjc2NS0zLjM3MS0yLjg4OC0zLjU4Ny0zLjM0NGMtMC4yMjQtMC41MjEtMC4yNTctMC45MjktMC4xMTUtMS4yOGMwLjI0Ny0wLjU1OSwwLjc4OC0wLjY2NiwxLjE0Ni0wLjczNyBjMC4xMDQtMC4wMjEsMC4yMDYtMC4wMzksMC4yOTUtMC4wNzJjMC4wMjEtMC4wMTIsMC4wNzItMC4wMywwLjEyNi0wLjA0NmwwLjEyMi0wLjA1M2MwLjI5MS0wLjEwNCwwLjM5MS0wLjIwMiwwLjQwMi0wLjIyOCBsLTAuMDM1LTAuMDM3Yy0wLjE1OCwwLjAwMy0wLjI2LDAuMDA4LTAuMzM3LDAuMDI0Yy0wLjI1NSwwLjA1NC0wLjQ5NywwLjA2MS0wLjY4LDAuMDYxTDIwLjMsMTQuMjUxIGMtMC40OTktMC4wNjYtMS4wMjYtMC40MzctMS4xNzgtMC41NDlsLTAuMjU3LTAuMTlsMC4wNjUtMC4zMTNjMC4wMDMtMC4wMTgsMC4wMDgtMC4wMzcsMC4wMTMtMC4wNTZsLTAuMDIzLTAuMTMxbDAuMDE3LTAuMzkzIGMwLjA0Ni0xLjA3NSwwLjEwMy0yLjQxMy0wLjE5NC0zLjA4MkMxNy43NDMsNy4yNDcsMTUuOTA2LDcsMTUuMTYyLDdoLTAuMzg1Yy0wLjkwNCwwLTIuNTcsMC4zMjgtMy41NjcsMi41MjIgYy0wLjE2OSwwLjQzMi0wLjIzNiwyLjA5NS0wLjEzMSwzLjQ2NWMwLjAyMSwwLjA1NCwwLjA0NCwwLjE4LTAuMDA5LDAuMzQxdjAuMjA2bC0wLjEzNSwwLjExNyBjLTAuMDA3LDAuMDA3LTAuNzA0LDAuNjQ3LTEuMzQ0LDAuNjQ3bC0wLjE1NCwwLjAwNmMtMC4yMzMsMC4wMTMtMC40MzgsMC0wLjc3My0wLjA5NGMtMC4wNC0wLjAwOS0wLjE4LTAuMDI5LTAuMjI1LTAuMDI5IGMtMC4wMzQsMC0wLjA3NywwLjAxMS0wLjA4NiwwLjA2MmMtMC4wMDMsMC4wMDEsMC4wNjEsMC4wOTcsMC4zOTYsMC4yMTVsMC4xMjIsMC4wNTNjMC4wNCwwLjAxMiwwLjA3NywwLjAyNCwwLjExMiwwLjAzOSBjMC4wNTQsMC4wMTIsMC4xMSwwLjAyMywwLjE3LDAuMDM1YzAuNDA1LDAuMDc5LDEuMDE4LDAuMTk4LDEuMjc5LDAuNzg3YzAuMTQ3LDAuMzcsMC4xMTUsMC43NzctMC4wOTMsMS4yNjRsLTAuMDY1LDAuMTI2IGMtMC44NTYsMS42NjMtMi4wNzksMi43OTctMy40OTIsMy4yNjJjMC4yODgsMC4xMDEsMC43NDMsMC4yMjIsMS40NTEsMC4zNGMwLjAwMywwLDAuMDA2LDAsMC4wMDksMCBjMC40MTcsMCwwLjU1NSwwLjQ5MiwwLjY0NiwwLjgxOWwwLjA1MSwwLjI1YzAsMC4wMzEsMC4wMDksMC4wNzMsMC4wMjEsMC4xMmMwLjAzMS0wLjAwMywwLjA2MS0wLjAwOSwwLjA4Ny0wLjAxNyBDOS40NjUsMjEuNDQ5LDkuODI3LDIxLjQxNCwxMC4yMTYsMjEuNDE0eiI+PC9wYXRoPjwvZz4KPC9zdmc+" /></a>
                                    </li>
                                @endif
                                @if (!empty($basicFields['blogger']))
                                <li><a href="{{ $basicFields['blogger'] }}" class="color-blogger"><img alt="svgImg" src="https://cdn-icons-png.flaticon.com/512/3669/3669967.png" style="width: 35px;"/></a> </li>
                            @endif

                                @if (!empty($basicFields['tiktok']))
                                    <li><a href="{{ $basicFields['tiktok'] }}" class="color-tiktok"><img alt="svgImg"
                                                style="background-color: aliceblue;width: 31px"
                                                src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCA1MCA1MCI+CjxwYXRoIGQ9Ik0gOSA0IEMgNi4yNDk1NzU5IDQgNCA2LjI0OTU3NTkgNCA5IEwgNCA0MSBDIDQgNDMuNzUwNDI0IDYuMjQ5NTc1OSA0NiA5IDQ2IEwgNDEgNDYgQyA0My43NTA0MjQgNDYgNDYgNDMuNzUwNDI0IDQ2IDQxIEwgNDYgOSBDIDQ2IDYuMjQ5NTc1OSA0My43NTA0MjQgNCA0MSA0IEwgOSA0IHogTSA5IDYgTCA0MSA2IEMgNDIuNjcxNTc2IDYgNDQgNy4zMjg0MjQxIDQ0IDkgTCA0NCA0MSBDIDQ0IDQyLjY3MTU3NiA0Mi42NzE1NzYgNDQgNDEgNDQgTCA5IDQ0IEMgNy4zMjg0MjQxIDQ0IDYgNDIuNjcxNTc2IDYgNDEgQyA2IDcuMzI4NDI0MSA3LjMyODQyNDEgNiA5IDYgeiBNIDI2LjA0Mjk2OSAxMCBBIDEuMDAwMSAxLjAwMDEgMCAwIDAgMjUuMDQyOTY5IDEwLjk5ODA0NyBDIDI1LjA0Mjk2OSAxMC45OTgwNDcgMjUuMDMxOTg0IDE1Ljg3MzI2MiAyNS4wMjE0ODQgMjAuNzU5NzY2IEMgMjUuMDE2MTg0IDIzLjIwMzAxNyAyNS4wMDk3OTkgMjUuNjQ4NzkgMjUuMDA1ODU5IDI3LjQ5MDIzNCBDIDI1LjAwMTkyMiAyOS4zMzE2NzkgMjUgMzAuNDk2ODMzIDI1IDMwLjU5Mzc1IEMgMjUgMzIuNDA5MDA5IDIzLjM1MTQyMSAzMy44OTI1NzggMjEuNDcyNjU2IDMzLjg5MjU3OCBDIDE5LjYwODg2NyAzMy44OTI1NzggMTguMTIxMDk0IDMzLjQwMjg1MyAxOC4xMjEwOTQgMzAuNTM5MDYyIEMgMTguMTIxMDk0IDI4LjY3NTI3MyAxOS42MDg4NjcgMjcuMTg3NSAyMS40NzI2NTYgMjcuMTg3NSBDIDIxLjUzNTc5NiAyNy4xODc1IDIxLjY2MzA1NCAyNy4yMDgyNDUgMjEuODgwODU5IDI3LjIzNDM3NSBBIDEuMDAwMSAxLjAwMDEgMCAwIDAgMjMgMjYuMjQwMjM0IEwgMjMgMjIuMDM5MDYyIEEgMS4wMDAxIDEuMDAwMSAwIDAgMCAyMi4wNjI1IDIxLjA0MTAxNiBDIDIxLjkwNjY3MyAyMS4wMzEyMTYgMjEuNzEwNTgxIDIxLjAxMTcxOSAyMS40NzI2NTYgMjEuMDExNzE5IEMgMTYuMjIzMTMxIDIxLjAxMTcxOSAxMS45NDUzMTMgMjUuMjg5NTM3IDExLjk0NTMxMiAzMC41MzkwNjIgQyAxMS45NDUzMTIgMzUuNzg4NTg5IDE2LjIyMzEzMSA0MC4wNjY0MDYgMjEuNDcyNjU2IDQwLjA2NjQwNiBDIDI2LjcyMjA0IDQwLjA2NjQwOSAzMSAzNS43ODg1ODggMzEgMzAuNTM5MDYyIEwgMzEgMjEuNDkwMjM0IEMgMzIuNDU0NjExIDIyLjY1MzY0NiAzNC4yNjc1MTcgMjMuMzkwNjI1IDM2LjI2OTUzMSAyMy4zOTA2MjUgQyAzNi41NDI1ODggMjMuMzkwNjI1IDM2LjgwMjMwNSAyMy4zNzQ0NDIgMzcuMDUwNzgxIDIzLjM1MTU2MiBBIDEuMDAwMSAxLjAwMDEgMCAwIDAgMzcuOTU4OTg0IDIyLjM1NTQ2OSBMIDM3Ljk1ODk4NCAxNy42ODU1NDcgQSAxLjAwMDEgMS4wMDAxIDAgMCAwIDM3LjAzMTI1IDE2LjY4NzUgQyAzMy44ODY2MDkgMTYuNDYxODkxIDMxLjM3OTgzOCAxNC4wMTIyMTYgMzEuMDUyNzM0IDEwLjg5NjQ4NCBBIDEuMDAwMSAxLjAwMDEgMCAwIDAgMzAuMDU4NTk0IDEwIEwgMjYuMDQyOTY5IDEwIHogTSAyNyAxMiBMIDI5LjMwMjI2NiAxMiBjIDMwLjA0OTA0NyAxNS4yOTg3IDMyLjYyNjczNCwxNy44MTQ0MDQgMzUuOTU4OTg0IDE4LjQ0NTMxMiAzNS45NTg5ODQgMjEuMzEwNTQ3QyAzMy44MjAxNDEgMjEuMjAxOTM1IDMxLjk0MTQ4OSAyMC4xMzQ5NDggMzAuODM1OTM4IDE4LjQ1MzEyNSAxNi4xMjEwOTQgMjcuNzYyMjQ2IDE2LjEyMTA5NCAzMC41MzkwNjIgQyAxNi4xMjEwOTQgMzMuNDgzMjc0IDE4LjUyODQ0NSAzNS44OTI1NzggMjEuNDcyNjU2IDM1Ljg5MjU3OCBDMjQuNDAxODkyIDM1Ljg5MjU3OCAyNyAzMy41ODY0OTEgMjcgMzAuNTkzNzUgQyAyNyAzMC42NDI2NyAyNy4wMDE4NTkgMjkuMzM1NTcxIDI3LjAwNTg1OSAyNy40OTQxNDEgQyAyNy4wMDk3NTkgMjUuNjUyNzEgMjcuMDA2MjI0IDIzLjIwNjkyMiAyNy4wMjE0ODQgMjAuNzYzNjcyIEMgMjcuMDMwODg0IDE2LjM3Njc3NSAyNy4wMzkyMTYgMTIuODQ5MjA2IDI3IDExIEggTTI3LjA0MTAxNiAxMiBMIDM5IDEyIEMgNDEuNzczNjY2IDEyIDQ0IDguMjI2MzMzOSA0NCAxMSBMIDQ0IDEwIEMgNDQgNDEuNzczNjY2IDQxLjc3MzY2NiA0NCAzOSA0NCAxMSBMIDM5IDEwIEMgMzYuMjI2MzMzOSAxMiAzNC4wODU5MzggMTIgMjcuMDQxMDE2IDEyIHoiIHN0eWxlPSJiYWNrZ3JvdW5kLWNvbG9yOiNhbGljZWJ1O3dpZHRoOjMxc2VydmVyLnNwYWNlLWJhY2tncm91bmQ6bm9uZTt3aWR0aDozMXB4O2JhY2tncm91bmQtY29sb3I6YWxpY2VidXk7d2lkdGg6MzFweDsiPjwvcGF0aD4KPC9zdmc+"></a>
                                    </li>
                                @endif
                                @if (!empty($basicFields['x']))
                                    <li><a href="{{ $basicFields['x'] }}">
                                            <img alt="svgImg"
                                                src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDUwIDUwIj4KPHBhdGggZD0iTSAxMSA0IEMgNy4xNDU2NjYxIDQgNCA3LjE0NTY2NjEgNCAxMSBMIDQgMzkgQyA0IDQyLjg1NDMzNCA3LjE0NTY2NjEgNDYgMTEgNDYgTCAzOSA0NiBDIDQyLjg1NDMzNCA0NiA0NiA0Mi44NTQzMzQgNDYgMzkgTCA0NiAxMSBDIDQ2IDcuMTQ1NjY2MSA0Mi44NTQzMzQgNCAzOSA0IEwgMTEgNCB6IE0gMTEgNiBMIDM5IDYgQyA0MS43NzM2NjYgNiA0NCA4LjIyNjMzMzkgNDQgMTEgTCA0NCAzOSBDIDQ0IDQxLjc3MzY2NiA0MS43NzM2NjYgNDQgMzkgNDQgTCAxMSA0NCBDIDguMjI2MzMzOSA0NCA2IDQxLjc3MzY2NiA2IDM5IEwgNiAxMSBDIDYgOC4yMjYzMzM5IDguMjI2MzMzOSA2IDExIDYgeiBNIDEzLjA4NTkzOCAxMyBMIDIyLjMwODU5NCAyNi4xMDM1MTYgTCAxMyAzNyBMIDE1LjUgMzcgTCAyMy40Mzc1IDI3LjcwNzAzMSBMIDI5Ljk3NjU2MiAzNyBMIDM3LjkxNDA2MiAzNyBMIDI3Ljc4OTA2MiAyMi42MTMyODEgTCAzNiAxMyBMIDMzLjUgMTMgTCAyNi42NjAxNTYgMjEuMDA5NzY2IEwgMjEuMDIzNDM4IDEzIEwgMTMuMDg1OTM4IDEzIHogTSAxNi45MTQwNjIgMTUgTCAxOS45Nzg1MTYgMTUgTCAzNC4wODU5MzggMzUgTCAzMS4wMjE0ODQgMzUgTCAxNi45MTQwNjIgMTUgeiI+PC9wYXRoPgo8L3N2Zz4="
                                                style="width: 31px;background-color: aliceblue;"></a></li>
                                @endif
                                @if (!empty($basicFields['whatsapp']))
                                    <li><a href="{{ $basicFields['whatsapp'] }}" target="_blank"><img alt="svgImg"
                                                src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iMzAiIGhlaWdodD0iMzAiIHZpZXdCb3g9IjAgMCA0MCA0MCI+CjxwYXRoIGZpbGw9IiNmMmZhZmYiIGQ9Ik00LjIyMSwyOS4yOThsLTAuMTA0LTAuMTgxYy0xLjYwOC0yLjc4Ni0yLjQ1OS01Ljk2OS0yLjQ1OC05LjIwNSBDMS42NjMsOS43Niw5LjkyNiwxLjUsMjAuMDc4LDEuNWM0LjkyNiwwLjAwMiw5LjU1MywxLjkxOSwxMy4wMyw1LjM5OWMzLjQ3NywzLjQ4LDUuMzkyLDguMTA3LDUuMzkyLDEzLjAyOCBjLTAuMDA1LDEwLjE1My04LjI2OCwxOC40MTQtMTguNDIsMTguNDE0Yy0zLjA4Mi0wLjAwMi02LjEyNi0wLjc3Ni04LjgxMS0yLjI0bC0wLjE3NC0wLjA5NmwtOS4zODUsMi40Nkw0LjIyMSwyOS4yOTh6Ij48L3BhdGg+PHBhdGggZmlsbD0iIzc4OGI5YyIgZD0iTTIwLjA3OCwyTDIwLjA3OCwyYzQuNzkxLDAuMDAxLDkuMjkzLDEuODY3LDEyLjY3Niw1LjI1M0MzNi4xMzcsMTAuNjM5LDM4LDE1LjE0LDM4LDE5LjkyNyBjLTAuMDA1LDkuODc4LTguMDQzLDE3LjkxNC0xNy45MjcsMTcuOTE0Yy0yLjk5MS0wLjAwMS01Ljk1Mi0wLjc1NS04LjU2NC0yLjE4bC0wLjM0OS0wLjE5bC0wLjM4NCwwLjEwMWwtOC4zNTQsMi4xOSBsMi4yMjYtOC4xMzFsMC4xMS0wLjQwM0w0LjU1LDI4Ljg2N2MtMS41NjYtMi43MTEtMi4zOTMtNS44MDgtMi4zOTEtOC45NTVDMi4xNjMsMTAuMDM2LDEwLjIwMiwyLDIwLjA3OCwyIE0yMC4wNzgsMSBDOS42NTEsMSwxLjE2Myw5LjQ4NSwxLjE1OCwxOS45MTJjLTAuMDAyLDMuMzMzLDAuODY5LDYuNTg4LDIuNTI1LDkuNDU1TDEsMzkuMTY5bDEwLjAzLTIuNjNjMi43NjMsMS41MDcsNS44NzUsMi4zLDkuMDQyLDIuMzAyIGgwLjAwOGMxMC40MjcsMCwxOC45MTUtOC40ODUsMTguOTItMTguOTE0YzAtNS4wNTQtMS45NjYtOS44MDctNS41MzgtMTMuMzgyQzI5Ljg5LDIuOTcxLDI1LjE0LDEuMDAyLDIwLjA3OCwxTDIwLjA3OCwxeiI+PC9wYXRoPjxwYXRoIGZpbGw9IiM3OWJhN2UiIGQ9Ik0xOS45OTUsMzVjLTIuNTA0LTAuMDAxLTQuOTgyLTAuNjMyLTcuMTY2LTEuODIzbC0xLjQzMy0wLjc4MmwtMS41NzksMC40MTRsLTMuMjQxLDAuODVsMC44My0zLjAzCWwwLjQ1My0xLjY1Nkw3LDI3LjQ4NWMtMS4zMDktMi4yNjctMi4wMDEtNC44NTgtMi03LjQ5MkM1LjAwNCwxMS43MjYsMTEuNzMyLDUuMDAxLDE5Ljk5OCw1YzQuMDExLDAuMDAxLDcuNzc5LDEuNTYzLDEwLjYxLDQuMzk3CUMzMy40NDEsMTIuMjMxLDM1LDE1Ljk5OSwzNSwyMC4wMDVDMzQuOTk2LDI4LjI3MywyOC4yNjgsMzUsMTkuOTk1LDM1eiI+PC9wYXRoPjxwYXRoIGZpbGw9IiNmZmYiIGQ9Ik0yOC4yOCwyMy42ODhjLTAuNDUtMC4yMjQtMi42Ni0xLjMxMy0zLjA3MS0xLjQ2MmMtMC40MTMtMC4xNTEtMC43MTItMC4yMjQtMS4wMTIsMC4yMjQJYy0wLjMsMC40NS0xLjE2MSwxLjQ2Mi0xLjQyMywxLjc2MWMtMC4yNjIsMC4zLTAuNTI0LDAuMzM3LTAuOTc0LDAuMTEzYy0wLjQ1LTAuMjI0LTEuODk5LTAuNy0zLjYxNS0yLjIzMQljLTEuMzM3LTEuMTkxLTIuMjM5LTIuNjYzLTIuNTAxLTMuMTEzYy0wLjI2Mi0wLjQ1LTAuMDI5LTAuNjkzLDAuMTk3LTAuOTE3YzAuMjAyLTAuMjAyLDAuNDUtMC41MjUsMC42NzQtMC43ODdjMC4yMjQtMC4yNjIsMC4zLTAuNDUsMC40NS0wLjc1MWMwLjE1MS0wLjMsMC4wNzUtMC41NjMtMC4wMzgtMC43ODdjLTAuMTEzLTAuMjI0LTEuMDEyLTIuNDM3LTEuMzg3LTMuMzM2CWMtMC4zNjQtMC44NzYtMC43MzYtMC43NTctMS4wMTItMC43NzFjLTAuMjYyLTAuMDE0LTAuNTYyLTAuMDE1LTAuODYxLTAuMDE1Yy0wLjMsMC0wLjc4NywwLjExMy0xLjE5OCwwLjU2MWwtMS40MTEsMC40NWwxLjU3MywxLjUzNywxLjU3MywzLjc0OXMtMS42MTEsNC4zNS0xLjgzNSw0LjY0OWMtMC4yMjQsMC4zLTMuMTY5LDQuODM5LTcuNjg2LDYuNzg0Yy0xLjA3MiwwLjQ2Mi0xLjkxMSwwLjczOS0yLjU2MiwwLjk0N2MtMS4wNzYsMC4zNDItMi4wNTcsMC4yOTQtMi44MzIsMC4xNzhjLTAuODY0LTAuMTI5LTIuNjYtMS4wODctMy4wMzQtMi4xMzRjLTAuMzc1LTEuMDQ5LTAuMzc1LTEuOTUsMC4yNjItMi4xMzZDMjkuMDMsMjQuMDI1LDI4LjczMSwyMy45MTIsMjguMjgsMjMuNjg4eiI+PC9wYXRoPgo8L3N2Zz4="></a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="copyright-area">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="inner text-center">
                                    <p>Copyright
                                        <script>
                                            document.write(new Date().getFullYear())
                                        </script> Developed By <a href="{{ config('developer.link') }}"
                                            target="_blank">{{ config('developer.name') }}</a>. All Rights Reserved
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
</footer>

<script>
    $(document).ready(function() {
        $('#subscribe-button').click(function() {
            var email = $('#subscriber-email').val();
            $.ajax({
                url: '/subscribe',
                method: 'POST',
                data: {
                    email: email,
                    _token: '{{ csrf_token() }}' // تأكد من إضافة CSRF token
                },
                success: function(response) {
                    alert(response.message);
                    $('#subscriber-email').val(
                        ''); // مسح حقل البريد الإلكتروني بعد الاشتراك
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    alert(errors.email[0]); // عرض رسالة الخطأ
                }
            });
        });
    });
</script>


<a href="https://wa.me/{{ $basicFields['whatsapp'] ?? '' }}" class="whatsapp-float" target="_blank">
    <i class="fab fa-whatsapp my-float"></i>
</a>
