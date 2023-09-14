<!-- ======= Recent Blog Posts Section ======= -->
<section id="recent-blog-posts" class="recent-blog-posts">

    <div class="container" data-aos="fade-up">

        <header class="section-header">
            <h2>Berita</h2>
            <p>Berita Terbaru</p>
        </header>

        <div class="row">
            @foreach ($news as $item)
            <div class="col-lg-4">
                <div class="post-box">
                    <div class="post-img"><img
                            src=" {{ $item->thumbnail ? '/storage/images/post_images/'.$item->thumbnail : '/storage/images/post_images/dummy.png' }} "
                            class="img-fluid" alt=""></div>
                    <span class="post-date">{{ $item->updated_at->isoFormat('dddd, D MMMM Y'); }}</span>
                    <h3 class="post-title">{{ $item->judul }}
                    </h3>
                    <a href="blog-single.html" class="readmore stretched-link mt-auto"><span>Read More</span><i
                            class="bi bi-arrow-right"></i></a>
                </div>
            </div>
            @endforeach
        </div>

        <a href="#" class="btn-discover">Lebih Banyak</a>
    </div>

</section>