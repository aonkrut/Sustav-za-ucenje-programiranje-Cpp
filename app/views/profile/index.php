<div class="max-w-lg mx-auto mt-10 p-8 border border-gray-200 shadow-lg rounded-lg bg-white">
    <!-- Naslov profila -->
    <h1 class="text-3xl font-extrabold text-center text-gray-800 mb-6">
        👤 Profil korisnika
    </h1>

    <!-- Informacije o korisniku -->
    <div class="space-y-4">
        <div class="flex justify-between items-center border-b pb-3">
            <span class="text-lg font-semibold text-gray-700">Ime:</span>
            <span class="text-lg text-gray-900"><?php echo $first_name; ?></span>
        </div>

        <div class="flex justify-between items-center border-b pb-3">
            <span class="text-lg font-semibold text-gray-700">Prezime:</span>
            <span class="text-lg text-gray-900"><?php echo $last_name; ?></span>
        </div>

        <div class="flex justify-between items-center border-b pb-3">
            <span class="text-lg font-semibold text-gray-700">Email:</span>
            <span class="text-lg text-gray-900"><?php echo $email; ?></span>
        </div>

        <div class="flex justify-between items-center border-b pb-3">
            <span class="text-lg font-semibold text-gray-700">Opcije (pažljivo):</span>
            <span class="text-lg text-gray-900">
                <a href="   <?php
                 echo BASE_PATH . '/admin'
            ?>">dodavanje zadatka</a>
             </span>
        </div>
    </div>
   

    <!-- Gumb za odjavu -->
    <form id="logoutForm" method="POST" class="mt-8">
        <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold py-3 rounded-lg shadow-lg hover:scale-105 hover:shadow-xl transition-all duration-300 ease-in-out text-lg">
             Odjavi se
        </button>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#logoutForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            console.log(formData);

            $.ajax({
                url: '<?php echo BASE_PATH?>/profile/logoutUser',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Uspješno ste odjavljeni',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(function() {
                            window.location.href = '<?php echo BASE_PATH ?>/login';
                        }, 1500);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Greška',
                            text: response.message
                        });
                    }
                }
            });
        });
    });
</script>


