<main id="main" class="">
    <!-- Hero Section -->
    <section class="bg-blue-800 text-white py-20 text-center">
        <div class="container mx-auto px-6">
            <h1 class="text-5xl font-extrabold">Nauči programirati u C++</h1>
            <div class="mt-6">
                <p class="text-lg"><b>Dobrodošli na platformu za samostalno učenje!</b></p>
            </div>
            <a class="mt-6 inline-block px-6 py-3 bg-blue-500 rounded-lg hover:bg-blue-600 transition" href="<?php echo BASE_PATH ?>/spcp">Započni učenje</a>
        </div>
    </section>


    <!-- Features Section -->

    <section class="py-20 bg-blue-100 dark:bg-blue-700">
        <div class="container mx-auto text-center mb-10">
            <h1 class="text-4xl font-extrabold text-blue-900 dark:text-blue-200">Trenutno dostupne značajke</h1>
            <p class="text-lg mt-2 text-blue-800 dark:text-blue-300">Istražite što vam naša platforma nudi kako biste unaprijedili svoje programerske vještine.</p>
        </div>
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-10 px-6">
            <div class="p-6 bg-blue-200 dark:bg-blue-600 rounded-lg shadow-lg hover:shadow-xl transition">
                <h3 class="text-2xl font-bold text-blue-900 dark:text-blue-100">Lekcije</h3>
                <p class="mt-2 text-blue-800 dark:text-blue-300">Učite kroz jasno strukturirane lekcije s teorijskim objašnjenjima.</p>
            </div>
            <div class="p-6 bg-blue-200 dark:bg-blue-600 rounded-lg shadow-lg hover:shadow-xl transition">
                <h3 class="text-2xl font-bold text-blue-900 dark:text-blue-100">Zadaci</h3>
                <p class="mt-2 text-blue-800 dark:text-blue-300">Praktični zadaci koji testiraju i poboljšavaju vaše programerske vještine.</p>
            </div>
            <div class="p-6 bg-blue-200 dark:bg-blue-600 rounded-lg shadow-lg hover:shadow-xl transition">
                <h3 class="text-2xl font-bold text-blue-900 dark:text-blue-100">Rješenja</h3>
                <p class="mt-2 text-blue-800 dark:text-blue-300">Dostupna rješenja za sve zadatke s mogućnošću slanja boljih prijedloga.</p>
            </div>
        </div>
    </section>


    <!-- Call to Action -->
    <section class="bg-blue-500 text-white py-16 text-center p-5">
        <h2 class="text-4xl font-bold">Vaša podrška je važna!</h2>
        <p class="mt-4">Naš cilj je da sustav ostane besplatan za sve korisnike, no to ograničava naše resurse. Molimo vas da ne zloupotrebljavate sustav kako bismo mogli podržati što više korisnika.</p>
        <p class="mt-4">Spreman za početak? Registriraj se i postani dio SPCP zajednice već danas!</p>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="<?php echo BASE_PATH ?>/spcp" class="mt-6 inline-block px-6 py-3 bg-white text-blue-500 rounded-lg hover:bg-gray-100 transition">Započni sa rješavanjem</a>
        <?php else: ?>
            <a href="<?php echo BASE_PATH ?>/login" class="mt-6 inline-block px-6 py-3 bg-white text-blue-500 rounded-lg hover:bg-gray-100 transition">Registriraj se</a>
        <?php endif; ?>
    </section>

</main>
<!-- Footer Section -->
<footer class="bg-blue-900 text-white text-center p-6">
    <p>&copy; 2025 salabahter.eu | Sva prava pridržana | Hvala vam na sudjelovanju!</p>
</footer>