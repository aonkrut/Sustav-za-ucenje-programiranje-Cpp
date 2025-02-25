<section class="bg-gray-50 dark:bg-gray-900 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-5xl p-6 bg-white rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
        <form id="taskForm" class="grid grid-cols-2 gap-6">
            <!-- public_id -->
            <input type="hidden" name="public_id" value="<?= $_SESSION['user_id'] ?>">
            <!-- Naziv -->
            <div class="col-span-2">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Naziv</label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    class="w-full px-4 py-2 mt-1 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                >
            </div>

            <!-- Tekst zadatka + odabiri (Lekcija, Težina, Vidljivost) -->
            <div class="col-span-1">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tekst zadatka</label>
                <textarea 
                    id="description" 
                    name="description" 
                    required 
                    class="w-full h-[160px] px-4 py-2 mt-1 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                ></textarea>
            </div>
            <div class="col-span-1 space-y-4">
                <!-- Lekcija -->
                <div>
                    <label for="lesson_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lekcija</label>
                    <select 
                        id="lesson_id" 
                        name="lesson_id" 
                        required 
                        class="w-full px-4 py-2 mt-1 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    >
                        <option value="" disabled selected>Odaberite lekciju</option>
                        <?php foreach ($lessons as $lesson): ?>
                            <option value="<?= htmlspecialchars($lesson['id']) ?>">
                                <?= htmlspecialchars($lesson['title']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- Težina -->
                <div>
                    <label for="difficulty" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Težina</label>
                    <select 
                        id="difficulty" 
                        name="difficulty" 
                        required 
                        class="w-full px-4 py-2 mt-1 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    >
                        <option value="" disabled selected>Odaberite težinu</option>
                        <?php foreach ($difficulties as $id => $label): ?>
                            <option value="<?= htmlspecialchars($id) ?>"><?= htmlspecialchars($label) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- Vidljivost -->
                <div>
                    <label for="visibility" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Vidljivost</label>
                    <select 
                        id="visibility" 
                        name="visibility" 
                        required 
                        class="w-full px-4 py-2 mt-1 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    >
                        <option value="" disabled selected>Odaberite vidljivost</option>
                        <?php foreach ($visibility as $id => $label): ?>
                            <option value="<?= htmlspecialchars($id) ?>"><?= htmlspecialchars($label) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Rješenje -->
            <div class="col-span-2">
                <label for="solution" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rješenje</label>
                <textarea 
                    id="solution" 
                    name="solution" 
                    class="w-full px-4 py-2 mt-1 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                ></textarea>
            </div>
            <!-- Ulaz i Izlaz -->
            <div>
                <label for="input" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ulaz</label>
                <textarea 
                    id="input" 
                    name="input" 
                    class="w-full px-4 py-2 mt-1 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                ></textarea>
            </div>
            <div>
                <label for="output" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Izlaz</label>
                <textarea 
                    id="output" 
                    name="output" 
                    class="w-full px-4 py-2 mt-1 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                ></textarea>
            </div>

            <!-- Objašnjenje -->
            <div class="col-span-2">
                <label for="explanation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Objašnjenje</label>
                <textarea 
                    id="explanation" 
                    name="explanation" 
                    class="w-full px-4 py-2 mt-1 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                ></textarea>
            </div>

            <!-- Submit dugme -->
            <div class="col-span-2">
                <button type="submit" class="w-full text-center bg-gradient-to-r from-[#7360DF] to-[#8472E5] text-white font-bold py-2 px-6 rounded shadow-lg hover:scale-105 hover:shadow-xl transition-transform transition-colors duration-300 ease-in-out ">
                    Dodaj
                </button>
            </div>
        </form>
    </div>
</section>

<script>
$(document).ready(function() {
    $('#taskForm').on('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        var formData = $(this).serialize();
        console.log(formData);

        // Send the form data using jQuery's AJAX method
        $.ajax({
            url: '<?php echo BASE_PATH?>/admin/addTask',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status == 'success') {
                    Swal.fire({
                        title: 'Uspješno!',
                        text: 'Zadatak je uspješno dodan!',
                        icon: 'success',
                        confirmButtonText: 'U redu',
                        customClass: {
                            confirmButton: 'text-black'
                        },
                        allowOutsideClick: false
                    })
                    .then(() => {
                        // Izbrisati podatke iz taskforme
                        $('#taskForm')[0].reset();
                    });
                } else if (response.status == 'error') {
                    Swal.fire({
                        title: 'Greška!',
                        text: 'Došlo je do greške!'+' Ako se greška ponavlja obratite se na info@salabahter.eu',
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
</script>
