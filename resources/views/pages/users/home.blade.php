@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <section class="flex flex-col md:flex-row text-center">
        <div class="bg-[#523433] w-full md:w-1/2 p-10 md:pl-24 md:pt-40 md:px-10 flex flex-col justify-center items-center">
            <h1 class="font text-[#e6dbd1] font-playfair text-5xl md:text-7xl font-bold mb-8">
                Saatnya Menikmati Kopi
            </h1>
            <p class="text-[#e6dbd1] text-lg mb-12 max-w-2xl mx-auto">
                Jika Anda minum kopi secara teratur, Anda akan tahu perbedaan antara kopi segar dan kopi lama.
                Tujuan kami adalah menyediakan dua buku kopi yang relevan setiap harinya.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-6 mb-10 md:mb-20">
                <button class="bg-amber-600 text-[#e6dbd1] px-8 py-4 rounded-full hover:bg-amber-700 transition">
                    Jelajahi Toko
                </button>
                <button
                    class="border-2 border-amber-600 text-amber-600 px-8 py-4 rounded-full hover:bg-amber-600/10 transition">
                    Buat Sendiri
                </button>
            </div>
        </div>
        <div class="w-full md:w-1/2 h-64 md:h-screen">
            <img class="w-full h-full object-cover" src="{{ asset('images/bannercoffe.jpg') }}" alt="Banner Kopi">
        </div>
    </section>

    <section class="bg-[#422424] p-10 md:p-24">
        <div class="flex flex-col md:flex-row justify-between items-center mb-12 md:mb-20 text-center md:text-left">
            <h3 class="text-4xl md:text-5xl text-[#e6dbd1] font-playfair font-bold mb-6 md:mb-0">
                Sajian Terbaik <br /> Dari Proses Berkualitas
            </h3>
            <p class="w-full md:w-96 text-[#e6dbd1]">
                Kami menyajikan kopi dengan standar kualitas tertinggi. Setiap proses pembuatan kopi kami dilakukan dengan
                penuh ketelitian untuk menghasilkan cita rasa yang sempurna.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 text-[#e6dbd1]">
            <div class="p-6 bg-[#523433] rounded-lg flex justify-center items-center flex-col gap-4 text-center">
                <svg viewBox="0 0 16 16" fill="#f8fafc" xmlns="http://www.w3.org/2000/svg" id="Java-Line--Streamline-Remix"
                    height="60" width="60">
                    <desc>Java Line Streamline Icon: https://streamlinehq.com</desc>
                    <path
                        d="M7.212866666666667 5.6176933333333325c-0.5060666666666667 -0.7229133333333333 -0.69692 -1.2476066666666665 -0.73834 -1.6294066666666664 -0.039126666666666664 -0.36062666666666665 0.04895333333333333 -0.6463266666666666 0.2236733333333333 -0.9220933333333333 0.18866666666666665 -0.2979 0.4718 -0.5749466666666666 0.8320666666666666 -0.9019066666666666 0.33666666666666667 -0.3056 0.7579333333333333 -0.6686933333333333 1.0884666666666667 -1.0800266666666665L7.579333333333333 0.24910466666666667c-0.2772 0.3449846666666666 -0.6184666666666666 0.6313219999999999 -0.9452133333333333 0.9278886666666667 -0.35603999999999997 0.32316666666666666 -0.7659533333333333 0.7078599999999999 -1.0623 1.1756866666666665 -0.3103733333333333 0.4899533333333333 -0.49938 1.0739666666666667 -0.42284666666666665 1.7794066666666666 0.07423333333333333 0.6842733333333333 0.39178 1.4220066666666666 0.9715933333333333 2.250253333333333l1.0922999999999998 -0.7646466666666667Zm0.8331999999999999 -2.01992c0.18986666666666666 -0.45568 0.5748 -0.91272 1.1867333333333332 -1.4372599999999998l0.8677333333333334 1.01234c-0.5547333333333333 0.47546 -0.7531333333333332 0.76842 -0.8236666666666667 0.9377399999999999 -0.06939999999999999 0.16646666666666665 -0.023399999999999997 0.33272 0.023266666666666665 0.4982 0.05566666666666667 0.19726 0.14839999999999998 0.52608 0.14246666666666666 0.8815 -0.0078 0.47025999999999996 -0.16899999999999998 0.9678399999999999 -0.5545333333333333 1.5461733333333332l-1.1094666666666666 -0.7395799999999999c0.28113333333333335 -0.4216533333333333 0.32826666666666665 -0.6740733333333333 0.33086666666666664 -0.8288133333333333 0.0032666666666666664 -0.19673999999999997 -0.04806666666666666 -0.3071 -0.13119999999999998 -0.6396999999999999 -0.07973333333333332 -0.31886 -0.14006666666666667 -0.7316666666666666 0.0678 -1.2306ZM4.0947 6.666566666666666c0.31281333333333333 -0.20938666666666667 0.6997399999999999 -0.31586 1.0612133333333333 -0.4028133333333333L4.844086666666667 4.9674c-0.5419933333333333 0.13037333333333334 -1.0342799999999999 0.3071466666666667 -1.408 0.5377933333333333C3.096053333333333 5.7150533333333335 2.6666666666666665 6.090539999999999 2.6666666666666665 6.66662c0 0.48417999999999994 0.3238133333333333 0.8707133333333333 0.7103266666666667 1.1238466666666667 -0.028319999999999998 0.122 -0.043660000000000004 0.24926666666666666 -0.043660000000000004 0.38126666666666664 0 0.6536 0.27869999999999995 1.2046666666666666 0.7618266666666667 1.6139999999999999 -0.07094666666666666 0.19939999999999997 -0.10308666666666666 0.42219999999999996 -0.09295333333333333 0.6452666666666667 -0.5182933333333333 0.10046666666666666 -1.02422 0.24853333333333333 -1.44664 0.4421333333333333 -0.28831999999999997 0.13213333333333332 -0.5721733333333333 0.301 -0.7935399999999999 0.5184666666666666C1.5391733333333333 11.610466666666667 1.3333333333333333 11.927533333333333 1.3333333333333333 12.333333333333332c0 0.2846666666666666 0.12575333333333333 0.5144666666666666 0.24921333333333331 0.6728666666666667 0.12602666666666668 0.16173333333333334 0.28805333333333333 0.2995333333333333 0.4561933333333333 0.41633333333333333 0.33745333333333327 0.2344 0.78952 0.446 1.3057266666666667 0.6242666666666666C4.38336 14.4056 5.790566666666667 14.666666666666666 7.333333333333333 14.666666666666666c2.2182 0 3.7751333333333332 -0.25593333333333335 4.793266666666666 -0.5215333333333333 0.5089999999999999 -0.13279999999999997 0.8825333333333334 -0.2678 1.1360666666666666 -0.3739333333333333 0.13973333333333332 -0.05846666666666667 0.28006666666666663 -0.1206 0.41079999999999994 -0.1978 0.007133333333333333 -0.004266666666666667 -0.6856666666666666 -1.1435333333333333 -0.6825333333333333 -1.1454 -0.3765333333333333 0.19606666666666664 -0.7920666666666666 0.32026666666666664 -1.2008666666666665 0.4269333333333333C10.891533333333332 13.089333333333332 9.448466666666667 13.333333333333332 7.333333333333333 13.333333333333332c-1.4027533333333333 0 -2.6622133333333333 -0.23893333333333333 -3.5536 -0.5468 -0.3541266666666667 -0.12226666666666666 -0.7250933333333333 -0.2653333333333333 -1.0271066666666666 -0.4928666666666666 0.07691999999999999 -0.060866666666666666 0.19384666666666664 -0.133 0.3584733333333333 -0.20846666666666663 0.37198 -0.17046666666666666 0.8819533333333333 -0.31033333333333335 1.4262799999999998 -0.3941333333333333 0.15272 0.16199999999999998 0.3351 0.3049333333333333 0.5433733333333333 0.42646666666666666C5.7242733333333335 12.492933333333333 6.608453333333333 12.666666666666666 7.666666666666666 12.666666666666666c0.8733333333333333 0 1.5051999999999999 -0.08786666666666666 1.9321333333333333 -0.18246666666666667 0.23693333333333333 -0.05246666666666667 0.4756666666666667 -0.11173333333333332 0.6946666666666667 -0.21893333333333334 0.0021333333333333334 -0.001 -0.5875333333333332 -1.1968666666666665 -0.5875333333333332 -1.1968666666666665 -0.12919999999999998 0.047266666666666665 -0.26106666666666667 0.08426666666666667 -0.39546666666666663 0.11406666666666666 -0.3254666666666667 0.07206666666666667 -0.8602666666666666 0.15086666666666665 -1.6438 0.15086666666666665 -0.9418 0 -1.5576066666666666 -0.1596 -1.9140866666666665 -0.3675333333333333 -0.2835933333333333 -0.1654 -0.39252 -0.34886666666666666 -0.41476 -0.5488 0.5786 0.16853333333333334 1.2637466666666666 0.24966666666666665 2.0371799999999998 0.24966666666666665 0.9757333333333333 0 1.6793333333333333 -0.09566666666666665 2.1521999999999997 -0.1978 0.2571333333333333 -0.05553333333333333 0.5170666666666666 -0.11946666666666667 0.7564666666666666 -0.23113333333333333 0.013533333333333331 -0.006466666666666667 -0.5718 -1.2045333333333332 -0.5718 -1.2045333333333332 -0.036533333333333334 0.014933333333333333 -0.18573333333333333 0.0718 -0.46613333333333334 0.13233333333333333 -0.3736 0.08073333333333332 -0.9824666666666666 0.16779999999999998 -1.8707333333333331 0.16779999999999998 -1.0687666666666666 0 -1.7809533333333332 -0.17626666666666668 -2.2016466666666665 -0.4155333333333333 -0.31399333333333335 -0.1786 -0.4518333333333333 -0.3785333333333333 -0.4928133333333333 -0.5931333333333333 0.8264466666666667 0.21766666666666667 1.8694 0.3419333333333333 2.9861266666666664 0.3419333333333333 1.2111333333333332 0 2.3343999999999996 -0.1462 3.1887999999999996 -0.39846666666666664l-0.3776 -1.2787333333333333c-0.7028 0.20753333333333335 -1.6937333333333333 0.34386666666666665 -2.8112 0.34386666666666665 -1.1491666666666664 0 -2.1633266666666664 -0.1442 -2.8680733333333333 -0.361 -0.33266666666666667 -0.10239999999999999 -0.5638333333333333 -0.2111333333333333 -0.7038933333333333 -0.30569999999999997Zm7.632299999999999 0.4972333333333333c0.8082666666666666 -0.07346666666666667 1.1061333333333332 0.12553333333333333 1.2022666666666666 0.2285333333333333 0.0994 0.10653333333333333 0.13419999999999999 0.2716666666666666 0.09066666666666667 0.44586666666666663 -0.07746666666666666 0.3097333333333333 -0.2951333333333333 0.6100666666666666 -0.6487999999999999 0.8859999999999999 -0.35239999999999994 0.27499999999999997 -0.8002666666666666 0.49353333333333327 -1.2485333333333333 0.6428666666666667l0.42146666666666666 1.265c0.5517333333333333 -0.18386666666666665 1.1455333333333333 -0.4651333333333333 1.6472666666666664 -0.8566666666666666 0.5005333333333333 -0.3905333333333333 0.9495333333333332 -0.9234 1.1220666666666665 -1.6138 0.12306666666666666 -0.49233333333333335 0.07453333333333333 -1.1605333333333332 -0.4093333333333333 -1.67902 -0.4872666666666666 -0.52204 -1.2726666666666666 -0.7397999999999999 -2.2977333333333334 -0.6466066666666667l0.12066666666666666 1.3278266666666667Z"
                        stroke-width="0.6667"></path>
                </svg>
                <h4 class="text-xl font-bold mb-4">Sangrai Tangan</h4>
            </div>
            <div class="p-6 bg-[#523433] rounded-lg flex justify-center items-center flex-col gap-4 text-center">
                <svg width="50" height="50" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M6.34511 0.832838C6.0672 0.834776 5.79286 0.874276 5.52658 0.953869C5.26239 1.03293 5.01902 1.14753 4.79814 1.29346C5.03945 1.90665 5.65549 2.68503 6.36908 3.34949C7.11414 4.04331 7.96845 4.63278 8.52017 4.89862L8.52664 4.90174L8.53299 4.90496C9.03999 5.16543 9.39892 5.57537 9.60611 6.02759C9.73955 6.31878 9.81727 6.62378 9.86258 6.93384C10.2688 6.61696 10.6971 6.36321 11.1325 6.17906C11.0993 5.60687 10.9735 5.00687 10.7442 4.40609C10.2634 3.14609 9.42358 2.13171 8.47249 1.51309C7.78889 1.06846 7.05533 0.827901 6.34511 0.832838ZM3.95736 2.15487C3.79758 2.40281 3.66655 2.67924 3.56699 2.97946C3.23449 3.98178 3.26145 5.23909 3.7423 6.49915C4.0333 7.26174 4.45595 7.93415 4.95511 8.48353C5.44686 8.63065 5.93324 8.85796 6.39011 9.1664C6.74311 9.40474 7.05767 9.67756 7.33027 9.97428C7.41924 9.9959 7.50824 10.0143 7.59714 10.0288C7.76652 9.58703 7.98636 9.14746 8.25727 8.72103C8.42117 8.46278 8.60077 8.21484 8.79508 7.97862C8.79733 7.81637 8.79602 7.65915 8.7883 7.50906C8.76736 7.10312 8.70236 6.75593 8.5833 6.49612C8.4643 6.23631 8.30924 6.05481 8.01892 5.90568L8.03174 5.91199C7.3168 5.56746 6.42402 4.93787 5.60236 4.17278C4.94924 3.56465 4.34336 2.88349 3.95736 2.15487ZM12.6996 6.39628C12.2775 6.39971 11.831 6.49774 11.3792 6.68528C10.4155 7.08534 9.4478 7.89621 8.73205 9.02268C8.36589 9.59899 8.10277 10.1999 7.93917 10.789C8.58136 11.8665 8.73908 13.1041 8.27645 14.1435C8.35125 14.2503 8.43472 14.3508 8.52602 14.4439C9.20239 13.8603 9.98189 13.3769 10.5359 12.8805C10.8387 12.6092 11.068 12.3407 11.1954 12.0849C11.3228 11.829 11.3666 11.5943 11.3004 11.2748L11.2965 11.2562L11.294 11.2374C11.0423 9.41574 11.4838 8.34518 12.1272 7.69024C12.6446 7.16368 13.1596 6.88634 13.5149 6.52018C13.2582 6.43487 12.9845 6.39393 12.6996 6.39628ZM14.4729 7.14481C13.9532 7.79074 13.3125 8.08909 12.9297 8.47874C12.4898 8.92649 12.1862 9.46546 12.4074 11.0757C12.5139 11.6232 12.4203 12.1491 12.2024 12.5864C11.9806 13.0317 11.649 13.3937 11.2866 13.7184C10.7362 14.2116 10.1013 14.6339 9.5702 15.0459C10.1725 15.2023 10.8583 15.1266 11.5566 14.8367C12.5204 14.4367 13.4881 13.6258 14.2038 12.4993C14.9196 11.3728 15.2425 10.1522 15.1953 9.10984C15.1592 8.31265 14.913 7.62959 14.473 7.14484L14.4729 7.14481ZM12.4074 11.0757C12.4055 11.0659 12.404 11.0561 12.4019 11.0463L12.4084 11.0836C12.4081 11.0809 12.4078 11.0783 12.4074 11.0757H12.4074ZM3.65039 8.84374C3.07592 8.83856 2.53477 8.96452 2.0793 9.21271C2.08242 9.21281 2.08514 9.21302 2.08827 9.21312C2.35795 9.22265 2.69652 9.19084 3.08633 9.24406C3.47611 9.29731 3.93274 9.47431 4.27864 9.86571C4.62458 10.2571 4.86177 10.812 5.02699 11.6088L5.03089 11.6274L5.03345 11.6462C5.11011 12.2022 5.46427 12.5239 6.07827 12.825C6.60214 13.082 7.27474 13.2655 7.91317 13.4523C8.19911 12.1711 7.52067 10.6084 6.07536 9.63262C5.29605 9.10649 4.4418 8.8509 3.65045 8.84374H3.65039ZM1.1167 10.139C0.327017 11.4993 0.960329 13.4954 2.68252 14.6581C4.37705 15.8022 6.42583 15.6667 7.41189 14.48C6.83577 14.3158 6.18264 14.1293 5.58283 13.8351C4.80939 13.4558 4.0722 12.8183 3.92345 11.8282C3.7818 11.1501 3.59252 10.7882 3.43564 10.6107C3.27814 10.4324 3.15533 10.389 2.93408 10.3588C2.71283 10.3286 2.40877 10.3502 2.04867 10.3375C1.76805 10.3276 1.4388 10.2873 1.1167 10.139V10.139ZM3.92349 11.8282C3.92417 11.8313 3.92486 11.8342 3.92552 11.8373L3.91905 11.8C3.92036 11.8095 3.92208 11.8187 3.92352 11.8282L3.92349 11.8282Z"
                        fill="#f8fafc" />
                </svg>
                <h4 class="text-xl font-bold mb-4">Kopi Organik</h4>
            </div>
            <div class="p-6 bg-[#523433] rounded-lg flex justify-center items-center flex-col gap-4 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                    id="Coffee-Espresso-Machine--Streamline-Ultimate" height="50" width="50">
                    <desc>Coffee Espresso Machine Streamline Icon: https://streamlinehq.com</desc>
                    <g id="Coffee-Espresso-Machine--Streamline-Ultimate.svg">
                        <path
                            d="M1 16h2.78a0.25 0.25 0 0 1 0.24 0.2A1 1 0 0 0 5 17h0.25a0.25 0.25 0 0 1 0.25 0.25v0.25a1 1 0 0 0 2 0v-0.25a0.25 0.25 0 0 1 0.25 -0.25H8a1 1 0 0 0 1 -1v-2a1 1 0 0 0 -1 -1H5a1 1 0 0 0 -1 0.8 0.25 0.25 0 0 1 -0.24 0.2H1a1 1 0 0 0 0 2Z"
                            fill="#f8fafc" stroke-width="1"></path>
                        <path
                            d="M22 0H6.5A3.5 3.5 0 0 0 3 3.5V9a1 1 0 0 0 1 1h0.75a0.25 0.25 0 0 1 0.25 0.25v1.25a0.5 0.5 0 0 0 0.5 0.5h2a0.5 0.5 0 0 0 0.5 -0.5v-1.25a0.25 0.25 0 0 1 0.25 -0.25H10a0.5 0.5 0 0 1 0.5 0.5v9a0.5 0.5 0 0 1 -0.5 0.5H1a1 1 0 0 0 -1 1v2a1 1 0 0 0 1 1h22a1 1 0 0 0 1 -1V2a2 2 0 0 0 -2 -2ZM7 5.5A1.5 1.5 0 1 1 8.5 4 1.5 1.5 0 0 1 7 5.5Zm14.75 3.75h-4a0.75 0.75 0 0 1 0 -1.5h4a0.75 0.75 0 0 1 0 1.5Zm0 -3h-4a0.75 0.75 0 0 1 0 -1.5h4a0.75 0.75 0 0 1 0 1.5Z"
                            fill="#f8fafc" stroke-width="1"></path>
                    </g>
                </svg>
                <h4 class="text-xl font-bold mb-4">Kopi Langsung</h4>
            </div>
        </div>
    </section>

    <section class="bg-[#523433] py-16 px-6 sm:px-12 md:px-24 text-[#e6dbd1] text-center">
        <h2 class="text-4xl md:text-5xl font-extrabold mb-4 drop-shadow font-jost">Produk Terbaru Kami</h2>
        <p class="max-w-xl mx-auto mb-12 text-gray-300">
            Kami selalu berusaha menghadirkan kopi single origin dari berbagai daerah dengan rasa yang khas. Ditujukan untuk
            para penikmat kopi sejati.
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-7xl mx-auto">
            @foreach ($latestMenus as $menu)
                <div class="product-card fade-in">
                    <div class="bg-white rounded-xl shadow-md text-left text-[#3e1f1f] relative overflow-hidden">
                        <a href="#">
                            <div class="p-4 w-full h-72">
                                <span class="absolute top-2 left-4 bg-[#5e3c3c] text-white px-2 py-1 text-xs rounded z-10">
                                    {{ $menu->kategori->nama_kategori_222297 }}
                                </span>
                                @if ($menu->path_img_222297)
                                    <img src="{{ asset('images/' . $menu->path_img_222297) }}"
                                        alt="{{ $menu->nama_222297 }}"
                                        class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-300">
                                @else
                                    <img src="{{ asset('images/coffe.png') }}" alt="{{ $menu->nama_222297 }}"
                                        class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-300">
                                @endif
                            </div>
                        </a>
                        <div class="bg-[#eee3d2] p-4">
                            <h3 class="font-semibold text-sm mb-2 truncate">{{ $menu->nama_222297 }}</h3>
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-base">Rp
                                    {{ number_format($menu->harga_222297, 0, ',', '.') }}</span>
                                <button
                                    class="bg-[#3e1f1f] hover:bg-[#5a2d2d] text-white text-xs px-3 py-1 rounded transition add-to-cart-btn"
                                    data-product-id="{{ $menu->kode_menu_222297 }}">
                                    ADD TO CART
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 flex justify-center items-center space-x-2">
            <span class="w-3 h-3 rounded-full bg-white opacity-50"></span>
            <span class="w-10 h-3 rounded-full bg-yellow-500"></span>
            <span class="w-3 h-3 rounded-full bg-white opacity-50"></span>
        </div>
    </section>

    <section class="bg-[#e6dbd1] py-16 px-6 sm:px-12 md:px-24">
        <div class="flex flex-col lg:flex-row justify-between items-center text-center lg:text-left">
            <div class="space-y-6 lg:w-1/2">
                <h2 class="text-4xl font-bold text-[#3C1E1E] leading-tight">
                    Reservasi Meja Lebih Mudah
                </h2>
                <p class="text-gray-700 text-lg lg:pr-20">
                    Hindari antrian dan pastikan kenyamananmu. Reservasi meja secara online hanya dengan beberapa klik.
                    Waktu berharga kamu tak akan terbuang sia-sia.
                </p>
                <a href="#"
                    class="inline-block bg-[#3C1E1E] text-white px-6 py-3 rounded-full font-medium hover:bg-[#2a1616] transition">
                    Reservasi Sekarang
                </a>
            </div>
            <div class="mt-10 lg:mt-0 lg:w-1/2 flex justify-center lg:justify-end">
                <img src="{{ asset('images/reservasi.jpg') }}" alt="Reservasi Meja"
                    class="max-w-sm md:max-w-md w-full rounded-xl shadow-lg object-cover">
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <style>
        /* Animasi Fade-in untuk Kartu Produk */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.5s ease-out forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Animasi Modal */
        .modal[open] {
            opacity: 1 !important;
            transform: scale(1) !important;
        }
    </style>

    <script>
        function toggleModal(modalId, show = true) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden', !show);
        }

        function isUserLoggedIn() {
            return {{ auth()->check() ? 'true' : 'false' }};
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const swiper = new Swiper('.swiper-container', {
                slidesPerView: 1, // Menampilkan satu slide per kali
                loop: true, // Slider akan kembali ke awal setelah slide terakhir
                autoplay: {
                    delay: 3000, // Interval antar slide (ms)
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination', // Elemen pagination
                    clickable: true, // Membuat pagination interaktif
                },
                speed: 600, // Kecepatan transisi slide (ms)
                effect: 'fade', // Tambahkan efek transisi jika ingin
                fadeEffect: {
                    crossFade: true, // Memperhalus efek transisi fade
                },
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const scrollToTopButton = document.getElementById("scrollToTopButton");

            if (scrollToTopButton) {
                window.addEventListener("scroll", () => {
                    if (window.scrollY > 200) { // Show button after scrolling 200px
                        scrollToTopButton.classList.remove("hidden");
                    } else {
                        scrollToTopButton.classList.add("hidden");
                    }
                });

                scrollToTopButton.addEventListener("click", () => {
                    window.scrollTo({
                        top: 0,
                        behavior: "smooth",
                    });
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('my_modal_3');
            if (modal) {
                modal.addEventListener('click', (event) => {
                    if (event.target === modal) {
                        modal.close();
                    }
                });
            }
        });

        // Tambahkan delay ke setiap kartu produk untuk animasi berurutan
        document.querySelectorAll('.product-card').forEach((el, index) => {
            el.style.animationDelay = `${index * 0.1}s`;
        });
    </script>
@endsection
