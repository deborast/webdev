<x-layout>
    <div class="row justify-content-center mt-4">
        <div class="col-md-8 col-lg-7">

            <div class="card shadow-sm border-0 rounded-4 mb-4" style="border: 1px solid #f3d4da;">
                <div class="card-body p-4">
                    <h3 class="mb-3" style="color:#5b0b18;">About White Dove Coffee</h3>

                    <p>
                        White Dove Coffee was established on 25 February 2023 with a simple idea:
                        serve good coffee in a calm, refreshing atmosphere close to the rice fields.
                        It is designed as a cozy place where you can study, work, or just chill with friends.
                    </p>

                    <p>
                        Every cup is prepared with care using selected beans and recipes.
                        From classic espresso-based drinks to signature frappes and teas, our menu
                        is created to match different tastes and moods throughout the day.
                    </p>

                    <hr class="my-4">

                    <h5 class="mb-2" style="color:#5b0b18;">Best menu, best view</h5>
                    <p>
                        One of the main highlights of White Dove Coffee is the view.
                        Located near the rice fields, the shop offers a natural green landscape that
                        makes it easy to relax, especially in the afternoon and evening.
                    </p>

                    <p class="mb-0">
                        Whether you come for a quick takeaway or want to sit for hours with your laptop,
                        we hope White Dove Coffee can become your favorite spot to slow down,
                        enjoy coffee, and feel at home.
                    </p>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4" style="border: 1px solid #f3d4da;">
                <div class="card-body p-4">
                    <h5 class="mb-3" style="color:#5b0b18;">Our Space & People</h5>

                    @php
                        $gallery = [
                            ['file' => 'images/in.png',          'alt' => 'Interior main area'],
                            ['file' => 'images/rockaside.png',   'alt' => 'Rocks'],
                            ['file' => 'images/4peeps.png',      'alt' => 'Customers enjoying coffee'],
                            ['file' => 'images/upper.png',       'alt' => 'Cozy corner for working'],
                            ['file' => 'images/mushola.png',     'alt' => 'Musholla'],
                            ['file' => 'images/ramai.png',       'alt' => 'Crowd'],
                            ['file' => 'images/team1.png',       'alt' => 'Our team'],
                            ['file' => 'images/team2.png',       'alt' => 'Our team'],
                            ['file' => 'images/yard.png',        'alt' => 'Ambience at the cafe'],
                            ['file' => 'images/smokingindor.png','alt' => 'Smoking Indoor'],
                        ];
                    @endphp

                    <div class="row g-3">
                        @foreach($gallery as $item)
                            <div class="col-6 col-md-6">
                                <div class="overflow-hidden rounded-3"
                                     style="height:220px; background:#111827;">
                                    <img src="{{ asset($item['file']) }}"
                                         alt="{{ $item['alt'] }}"
                                         class="img-fluid w-100 h-100"
                                         style="object-fit:cover; transition:transform .25s ease, opacity .25s ease;"
                                         onmouseover="this.style.transform='scale(1.04)'; this.style.opacity='0.95';"
                                         onmouseout="this.style.transform='scale(1)'; this.style.opacity='1';">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <small class="text-muted d-block mt-3" style="font-size:.85rem;">
                        A glimpse of our interior, rice-field view, and moments with our customers at White Dove Coffee.
                    </small>
                </div>
            </div>

        </div>
    </div>
</x-layout>
