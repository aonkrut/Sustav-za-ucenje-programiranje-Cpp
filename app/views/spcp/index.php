<body class="bg-gray-100 font-sans">
    <div class="max-w-6xl mx-auto p-6">
        <!-- Header -->
        <header class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-gray-800">Pregled lekcija</h1>
            <p class="text-gray-600 mt-2">Specijalizirane lekcije za programiranje u C++</p>
            <?php $pdfPath = BASE_PATH . "/public/assets/scripts/lekcija-sve" . ".pdf"; ?>
             <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . parse_url($pdfPath, PHP_URL_PATH)) && isset($_SESSION['user_id'])): ?>
                <br>
                <a href="<?= $pdfPath ?>" 
                   class="inline-flex items-center justify-center gap-1.5 rounded border border-blue-200 bg-blue-100 px-5 py-3 text-gray-900 transition hover:text-gray-700 focus:outline-none focus:ring"
                   download
                   onclick="recordDownload(100)">
                    <span class="text-sm font-medium">Preuzmi skriptu</span>
                </a>
            <?php endif; ?>
        
        <script>
            function recordDownload(lessonId) {
                fetch('spcp/zabiljeziSkidanjeSkripte/' + lessonId, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({}),
                });
            }
        </script>
        </header>

        <!-- Content -->
        <main>
        <?php if (!empty($message)): ?>
    <div class="alert alert-info bg-blue-100 text-blue-800 px-4 py-2 rounded mb-4">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>
            <?php
            
            if (!empty($lessons)): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($lessons as $lesson): ?>
                        <!-- Lekcija kartica -->
                        <a href="<?php echo BASE_PATH ?>/spcp/lekcija/<?= htmlspecialchars($lesson['id']) ?>" 
                           class="block p-6 bg-white shadow rounded-lg hover:shadow-md hover:bg-gray-50 transition">
                            <h2 class="text-xl font-semibold text-gray-800">
                                <?= htmlspecialchars($lesson['title']) ?>
                            </h2>
                            <p class="text-gray-600 text-sm mt-2">
                                <?= htmlspecialchars(mb_substr($lesson['description'], 0, 30)) . '...' ?>
                            </p>

                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-center text-gray-600">Nema dostupnih lekcija.</p>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
