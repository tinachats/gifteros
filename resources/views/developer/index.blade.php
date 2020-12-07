@include('layouts.includes.header')
@include('layouts.includes.main-nav')
<!-- Page Content -->
<div class="container page-content" id="profile-page">
    <!-- Content Header (Page header) -->
    <div class="content-header mt-md-5">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="text-capitalize font-600 m-0 p-0">Gifteros Developer</h5>
                <ol class="breadcrumb float-sm-right bg-transparent">
                    <li class="breadcrumb-item d-none d-md-inline">
                        <a href="/" class="d-flex align-items-center text-primary">
                            <i class="material-icons">store</i>
                        </a>
                    </li>
                    <li class="breadcrumb-item text-capitalize d-none d-md-inline">Developers</li>
                    <li class="breadcrumb-item active text-capitalize">{{ $title }}</li>
                </ol>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Page Content -->
    <div class="container-fluid mb-5">
        <div class="row main-section">
            <!-- Developer Profile -->
            <div class="col-12 col-md-4 order-md-2 mb-3">
                <img src="{{ asset('storage/developers/tinashe.chaterera.jpg') }}" alt="{{ $title }}" class="img-fluid rounded">
                <h6 class="mt-1 mb-0 text-sm text-muted">Project</h6>
                <h5 class="text-primary text-md font-600">Gifteros</h5>
                <h6 class="mt-2 mb-0 text-sm text-muted">Location</h6>
                <h5 class="text-secondary text-md font-600">Waterfalls, Harare, Zimbabwe</h5>
                <h6 class="mt-2 mb-0 text-sm text-muted">Day Job</h6>
                <h5 class="text-secondary text-md font-600">Full-stack Web Developer at Gifteros Inc.</h5>
            </div>
            <!-- /.Developer Profile -->

            <!-- Developer Details -->
            <div class="col-12 col-md-8 order-md-1">
                <h2 class="title-heading text-capitalize">{{ $title }}</h2>
                <h5 class="text-capitalize">Backstory</h5>
                <p class="text-justify">
                    I did Mechatronics Engineering at Chinhoyi University of Technology (C.U.T) from August 2011 and graduated 
                    in October 2016. This is because I had always had an intense fascination in robotics and industrial automation, 
                    a passion that was kindled in me when I was young through watching Around Japan on ZTV during commercial breaks. 
                    So in my grade 8 I started reading a lot of books about space travel done by NASA and the kind of robots they send to 
                    Mars. 
                </p>
                <blockquote class="blockquote text-center">
                    <p class="mb-0 text-primary lead-2x">
                        <i class="fa fa-quote-left"></i>
                        I invest: my time with people who inspire, my resources with people who produce and my talent
                        with people who create.
                        <i class="fa fa-quote-right"></i>
                    </p>
                </blockquote>
                <p class="text-justify">
                    As far as software development is concerned, I started developing Graphical User Interfaces (GUI) with Visual Basic (VB) for 
                    Human Machine Interfaces (HMIs) for simulation projects that we did in Matlab-Simulink. This was my first introduction 
                    to the world of application development. This got me hooked with developing desktop applications and letter made me to learn C#. 
                    So when I graduated, my laptop was damaged and I didnn't have money to  fix it then so I got a job as a Physics teacher at a private college 
                    in Zimre Park. They had a computer lab and one day whilst reaching on something I stumpled upon a site called Excel-easy, which primarily focuses on Excel VBA lessons. 
                    That intrigued me and I spent the rest of my day doing all their modules and writing vba programs. So that revived my coding knowledge and I started developing a project  
                    which I thought would make master the language. 
                </p>
                <p class="text-justify">
                    I created a WhatsApp group (Science Yard) which taught Excel VBA lessons and joined other Excel groups which only focused on Excel functions and I will redo their solutions in Exel VBA. 
                    I then purchased a laptop and pursued my Excel VBA lessons until I then see that what I wanted to notice that with the kind of application I wanted to create, with Excel VBA it wasn't going 
                    to happen so I started focusing on C#. This took me a period of like 8 months of learning C# until a friend of mine who's a python programmer told me about Django, a python web-framework. Knowing 
                    python from my Matlab-Simulink projects as a simple and yet powerful language, I quickly switched to learning Django. This was with much help from tutorials I downloaded from YouTube from the likes of 
                    <a href="">Sentdex</a>, <a href="">The Coding Entrereneurs</a>, <a href="">Traversy media</a> and <a href="">Max Goodrich</a>. I was very fascinated in how powerful the Django framework was and how it simplified 
                    my tasks. Read a book for Django beginners, Django Girls, a book which my friend uses in teaching girls the Djjango framework. The name of the book suggests that it's meant for girls, but I didn't mind, all I wanted was to master the 
                    basics of the framework by all means necessary. 
                </p>
                <p class="text-justify">
                    So as I started getting deeper in learning the framework and in doing my project, I started noticing that 
                    content was beginning to be difficult to find on YouTube. Much of the content was about creating a blog, <a href="">Max Goodrich</a>
                    was the one who at least went a little deeper in making a Twitter-like webapp, his tutorial series spanned to like 60 videos. 
                </p>
            </div>
            <!-- /.Developer Details -->
        </div>
    </div>
    <!-- Page Content -->
</div>
<!-- /.Page Content -->
@include('layouts.includes.footer')