<!-- ======= Team Section ======= -->
<section id="team" class="team">

    <div class="container" data-aos="fade-up">

        <header class="section-header">
            <h2>Guru dan Karyawan</h2>
        </header>

        <div class="row gy-4">
            @foreach ($teachers as $item)

            <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                <div class="member">
                    <div class="member-img">
                        <img src=" {{'storage/images/teachers/'.$item->photo}} " class="img-fluid" alt="">
                    </div>
                    <div class="member-info">
                        <h4>{{ ucwords($item->name) }}</h4>
                        <span></span>
                    </div>
                </div>
            </div>

            @endforeach
        </div>

    </div>

</section><!-- End Team Section -->