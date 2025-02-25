<body class="bg-gray-100 font-sans">

    <header class="bg-gray-100">
        <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
            <div class="flex flex-col items-start gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl"><?= htmlspecialchars($lesson['title']) ?></h1>
                    <p class="mt-1.5 text-sm text-gray-500">
                        <?= nl2br(htmlspecialchars($lesson['description'])) ?>
                    </p>
                    <?php if($lesson['link']!=0):?>
                    <p class="mt-1.5 text-sm text-green-500 underline">
                        <a href="<?= nl2br(htmlspecialchars($lesson['link'])) ?>" target="_blank">video demonstrature (nije autorsko vlasništvo)</a> 
                    </p>
                    <?php endif;?>
                    <br>
                    <p class="mt-1.5 text-sm text-gray-500" >Za pregled mogućih zadataka odaberite težinu, za generiranje zadataka (simulacija PTGa) pritisnite Generiraj vježbu</p>
                </div>
                <div class="flex flex-wrap items-center gap-4">
                    <?php $pdfPath = BASE_PATH . "/public/assets/scripts/lekcija-" . htmlspecialchars($lesson['id']) . ".pdf"; ?>
<?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . parse_url($pdfPath, PHP_URL_PATH))): ?>
                        <!-- Additional content if file exists -->
                    <a href="<?= $pdfPath ?>" 
                       class="inline-flex items-center justify-center gap-1.5 rounded border border-gray-200 bg-white px-5 py-3 text-gray-900 transition hover:text-gray-700 focus:outline-none focus:ring"
                       download>
                        <span class="text-sm font-medium">Preuzmi skriptu</span>
                    </a>
                    
                    <?php endif; ?>
                   <?php if (isset($_SESSION['user_id'])) { ?>
    <a href="<?= htmlspecialchars(BASE_PATH . "/spcp/vjezba/" . $lesson['id']) ?>" 
       class="inline-block rounded bg-indigo-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-indigo-700 focus:outline-none focus:ring">
        Generiraj vježbu
    </a>
<?php } else { ?>
    <a href="<?= htmlspecialchars(BASE_PATH . "/login") ?>"
       class="inline-block rounded bg-indigo-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-indigo-700 focus:outline-none focus:ring">
        Prijavi se za generiranje zadataka
    </a>
<?php } ?>

                </div>
            </div>
            <br>
            <a href="<?php echo BASE_PATH ?>/spcp" class="text-blue-500 hover:underline">← Povratak na popis lekcija</a>
        </div>
    </header>

    <!-- Težine -->
    <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Pregled mogućih zadataka po težini:</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            <?php foreach ([1 => 'Lako', 2 => 'Srednje lako', 3 => 'Srednje', 4 => 'Teško', 5 => 'Vrlo teško', 6 => 'Napredno'] as $difficulty => $label): ?>
                <?php
                    $bgColor = match ($difficulty) {
                        1 => 'bg-green-400',
                        2 => 'bg-yellow-300',
                        3 => 'bg-yellow-400',
                        4 => 'bg-orange-400',
                        5 => 'bg-orange-500',
                        6 => 'bg-red-500',
                        default => 'bg-white',
                    };
                ?>
                <button 
                    class="px-4 py-2 rounded <?php echo $bgColor?> text-white hover:bg-blue-600 transition w-full text-center" 
                    onclick="showTasks('difficulty-<?= $difficulty ?>')">
                    <?= $label ?>
                </button>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Tasks Section -->
    <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <section>
            <?php if (!empty($tasksGrouped)): ?>
                <?php foreach ($tasksGrouped as $difficulty => $tasks): ?>
                    <div id="difficulty-<?= $difficulty ?>" class="hidden">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Težina: <?= $difficulty ?></h3>
                        <?php foreach ($tasks as $task): ?>
                            <div class="p-4 bg-white shadow rounded-lg border border-gray-200 mb-4">
                                <h4 class="text-lg font-semibold text-gray-800"> <input type="checkbox" class="size-4 rounded border-gray-300" id="ch-<?= htmlspecialchars($task['id'])?>"/> <?= htmlspecialchars($task['id'])?> - <?= htmlspecialchars($task['title']) ?> </h4>
                                <p class="text-gray-600 mt-2"><?= nl2br(htmlspecialchars($task['description'])) ?></p>
                                <?php if (!empty($task['solution'])): ?>
                                <button 
                                    class="mt-2 text-blue-500 hover:underline"
                                    onclick="toggleSolution('solution-<?= htmlspecialchars($task['id']) ?>')">
                                    Prikaži rješenje
                                </button>
                                <div id="solution-<?= htmlspecialchars($task['id']) ?>" class="hidden mt-4 bg-gray-50 p-4 border rounded-lg">
                                    <pre class="text-sm text-black-800 whitespace-pre-wrap overflow-auto">
                                    <?php 
                                    if (isset($_SESSION['user_id'])) {
                                        echo '<p class="text-gray-500">'.nl2br(htmlspecialchars($task['solution'])).'</p>';
                                    } else {
                                        echo '<p class="text-red-500">Morate biti prijavljeni da <br>biste vidjeli rješenje.</p>';
                                    }
                                    ?></pre>
                                      
                                </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-600">Trenutno nema javno dostupnih zadataka za ovu lekciju.</p>
            <?php endif; ?>
        </section>
    </div>

    <script>
        function showTasks(difficultyId) {
            document.querySelectorAll('[id^="difficulty-"]').forEach(group => {
                group.classList.add('hidden');
            });
            const group = document.getElementById(difficultyId);
            if (group) {
                group.classList.remove('hidden');
            }
        }

        function toggleSolution(id) {
            const element = document.getElementById(id);
            element.classList.toggle('hidden');
        }
    </script>
</body>
</html>
