<section id="contact" class="contact">
    <style>
        #map {
            height: 400px;
            width: 80%
        }
    </style>
    <div class="container" data-aos="fade-up">

        <header class="section-header">
            <h2>Kontak</h2>
            <p>Hubungi Kami</p>
        </header>

        <div class="row gy-4">

            <div class="col-lg-6">

                <div class="row gy-4">
                    <div class="col-md-6">
                        <div class="info-box">
                            <i class="bi bi-geo-alt"></i>
                            <h3>Alamat</h3>
                            <p>{{ $settings->address }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box">
                            <i class="bi bi-telephone"></i>
                            <h3>Telepon</h3>
                            <p>{{ phone($settings->phone, 'ID') }}<br>{{ phone($settings->phone2, 'ID') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box">
                            <i class="bi bi-envelope"></i>
                            <h3>Email</h3>
                            <p>{{ $settings->email }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box">
                            <i class="bi bi-megaphone"></i>
                            <h3>Sosial Media</h3>
                            <div class="social-links mt-3">
                                <a href="{{ $settings->youtube }}" target="_blank" class="youtube"><i
                                        class="bi bi-youtube social-icon"></i></a>
                                {{-- <a href="#" target="_blank" class="facebook"><i
                                        class="bi bi-facebook social-icon"></i></a> --}}
                                <a href="{{ $settings->instagram }}" target="_blank" class="instagram"><i
                                        class="bi bi-instagram social-icon"></i></a>
                                {{-- <a href="#" target="_blank" class="linkedin"><i
                                        class="bi bi-linkedin social-icon"></i></a> --}}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-6">
                <div id="map"></div>
                <div id="map"></div>
                <script>
                    function initMap() {
                        var options = {
                        zoom: 18,
                        center: { lat: -7.980776114853393, lng: 112.62597008743516 },
                        };
                        var map = new google.maps.Map(document.getElementById('map'), options);
                        var marker = new google.maps.Marker({
                        position: { lat: -7.980776114853393, lng: 112.62597008743516 },
                        map: map,
                        });
                    }
                </script>

            </div>

        </div>

    </div>

</section><!-- End Contact Section -->