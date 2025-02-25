<body class="bg-gray-100 font-sans">
    <br>
    <div class="max-w-7xl mx-auto p-6 bg-white shadow-lg rounded-lg">
        <!-- Header -->
        <header class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Zadaci iz područja: <?= htmlspecialchars($lesson['title']) ?></h1>
           
            <div class="mt-6 text-center">
                <button 
                    class="text-white bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded" 
                    onclick="$.ajax({
                        url: '<?php echo BASE_PATH?>/spcp/spcp/regenerateTasks',
                        type: 'POST',
                        data: { lessonId: '<?= htmlspecialchars($lesson['id']) ?>' },
                        success: function() {
                        
                            location.reload();
                        }
                    })">
                    Generiraj nove zadatke
                </button>
                
            </div>
        </header>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border-collapse border border-gray-300">
                <thead class="bg-stone-200">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left">ID</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Tema</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Zadatak</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Opcije</th>
                    </tr>
                </thead>
               <tbody>
    <?php $counter = 1; ?>
    <?php foreach ($randomTasks as $task): ?>
        <tr class="<?= $counter % 2 === 0 ? 'bg-stone-50' : 'bg-white' ?>">
            <td class="border border-gray-300 px-4 py-2 align-top"><?= htmlspecialchars($task['id']) ?> <input type="checkbox" class="size-4 rounded border-gray-300" /></td>
            <td class="border border-gray-300 px-4 py-2 align-top"><?= htmlspecialchars($lesson['title']) ?></td>
            <td class="border border-gray-300 px-4 py-2 align-top">
                <?= nl2br(htmlspecialchars($task['description'])) ?>
                <div id="solution-<?= htmlspecialchars($task['id']) ?>" class="hidden mt-2">
                <?php 
                    if (isset($_SESSION['user_id'])) {
                        ?>
                    <pre class="text-sm bg-gray-100 p-2 rounded border"><?= htmlspecialchars($task['solution']) ?></pre>
                    <?php
                    } else {
                        echo '<p class="text-red-500">Morate biti prijavljeni da biste vidjeli rješenje.</p>';
                    }
                    ?>
                </div>
                <div id="explanation-<?= htmlspecialchars($task['id']) ?>" class="hidden mt-2">
                    <pre id="exp-<?= htmlspecialchars($task['id']) ?>" class="text-sm bg-gray-100 p-2 rounded border"><?= htmlspecialchars($task['explanation']) ?></pre>
                </div>
                <br>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var explanationElement = document.getElementById('exp-<?= htmlspecialchars($task['id']) ?>');
                        if (explanationElement) {
                            var explanationText = explanationElement.innerText;
                            explanationElement.innerHTML = explanationText.replace(/(.{80})/g, '$1<br>');
                        }
                    });
                </script>
            </td>
            <td class="border border-gray-300 px-4 py-2 align-top">
                <?php if (empty($task['solution'])): ?>
                    <button
                        class="text-indigo-400 hover:underline"
                        onclick="openModal('<?= htmlspecialchars($task['id']) ?>')">
                        Dodaj rješenje
                    </button>
                <?php else: ?>
                    <button
                        class="text-blue-500 hover:underline"
                        onclick="toggleSolution('solution-<?= htmlspecialchars($task['id']) ?>')">
                        Rješenje
                    </button>
                    <br>
                <?php endif; 
                    if (!empty($task['explanation'])) { 
                ?>
                   <button
                        class="text-stone-600 hover:underline"
                        onclick="toggleSolution('explanation-<?= htmlspecialchars($task['id']) ?>')">
                        Objašnjenje
                    </button>
                <?php } ?>
                <br>
            </td>
        </tr>
        <?php $counter++; ?>
    <?php endforeach; ?>
</tbody>

            </table>
        </div>

        <!-- Footer -->
        <footer class="mt-6 text-center">
            <a href="<?php echo BASE_PATH ?>/spcp/lekcija/<?= htmlspecialchars($lesson['id']) ?>" class="block mt-2 text-blue-500 hover:underline">
                ← Povratak na lekciju
            </a>
        </footer>
    </div>

    <!-- Modal -->
    <div id="solutionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded shadow-lg max-w-lg w-full">
            <h2 class="text-xl font-bold mb-4">Unesite vaše rješenje</h2>
            <p class="mt-1.5 text-sm text-red-500" >Unesite rješenje samo ako ste 100% sigurni da je rješenje točno i jasno.</p>
            <form id="solutionForm" method="POST" action="/spcp/provjeri">
                <textarea 
                    id="userCode" 
                    name="userCode" 
                    class="w-full p-2 border rounded h-40" 
                    placeholder="Unesite vaš C++ kod ovdje..."></textarea>
                <input type="hidden" id="taskId" name="task_id" value="<?= htmlspecialchars($task['id']) ?>">
                <input type="hidden" name="lesson_id" value="<?= htmlspecialchars($lesson['id']) ?>">
                <div class="mt-4 flex justify-end">
                    <button 
                        type="button" 
                        class="text-gray-500 mr-4" 
                        onclick="closeModal()">
                        Odustani
                    </button>
                    <button 
                        type="submit" 
                        class="text-white bg-green-500 hover:bg-green-600 px-4 py-2 rounded">
                        Pošalji
                    </button>
                </div>
            </form>
            <!-- Animacija za provjeru -->
            <div id="loadingAnimation" class="hidden mt-4 flex justify-center items-center">
                <div class="w-5 bg-[#d991c2] animate-pulse h-5 rounded-full animate-bounce"></div>
                <div class="w-5 animate-pulse h-5 bg-[#9869b8] rounded-full animate-bounce"></div>
                <div class="w-5 h-5 animate-pulse bg-[#6756cc] rounded-full animate-bounce"></div>
            </div>
            <div id="resultMessage" class="hidden mt-4 p-2 text-white bg-green-500 rounded"></div>
        </div>
    </div>

    <div id="messageModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded shadow-lg max-w-lg w-full">
            <h2 class="text-xl font-bold mb-4">Poruka</h2>
            <p id="messageContent" class="text-gray-800"></p>
            <div class="mt-4 flex justify-end">
                <button
                    type="button"
                    class="text-white bg-red-500 hover:bg-red-600 px-4 py-2 rounded"
                    onclick="closeMessageModal()">
                    Zatvori
                </button>
            </div>
        </div>
    </div>
    

    <script>
        $(document).ready(function() {
            $('#solutionForm').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                var formData = $(this).serialize();
                console.log(formData);

                // Send the form data using jQuery's AJAX method
                $.ajax({
                    url: '<?php echo BASE_PATH?>/spcp/spcp/addSolution',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {
                            Swal.fire({
                                title: 'Uspješno!',
                                text: 'Rješenje je uspješno dodano! ' +
                                      'Uskoro će biti dostupno svima.',
                                icon: 'success',
                                confirmButtonText: 'U redu',
                                customClass: {
                                    confirmButton: 'text-black'
                                },
                                allowOutsideClick: false
                            })
                            .then(() => {
                                // Izbrisati podatke iz taskforme
                                closeModal();
                                //neka onda refresha stranicu
                                location.reload();
                            });
                        } else if (response.status == 'error') {
                            Swal.fire({
                                title: 'Greška!',
                                text: 'Došlo je do greške!'+'Ako se greška ponavlja obratite se na info@salabahter.eu',
                                icon: 'error',
                                confirmButtonText: 'Okay',
                                customClass: {
                                    confirmButton: 'text-black'
                                },
                                allowOutsideClick: false
                            })
                        }
                    },
                });
            });
        });

        function toggleSolution(id) {
            const element = document.getElementById(id);
            element.classList.toggle('hidden');
        }
        

        function openModal(taskId) {
            document.getElementById('taskId').value = taskId;
            document.getElementById('solutionModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('solutionModal').classList.add('hidden');
            document.getElementById('userCode').value = '';
            document.getElementById('resultMessage').classList.add('hidden');
        }

        function regenerateTasks(lessonId) {
            $.ajax({
                url: '<?php echo BASE_PATH?>/spcp/spcp/regenerateTasks',
                type: 'POST',
                data: { lessonId: lessonId },
                dataType: 'json',
                success: function(response) {
                   
                    }
                });
            }
        </script>
    
</body>
