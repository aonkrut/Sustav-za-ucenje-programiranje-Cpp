<section class="bg-gray-50 dark:bg-gray-900">
    <div class="flex flex-col items-center justify-center px-2 py-1 mx-auto md:h-screen lg:py-0">
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                                    Kreirajte svoj račun 
                            </h1>
                            <p class="mt-1.5 text-sm text-red-500" >Molimo za strpljenje prilikom registracije, jer proces učitavanja može potrajati nekoliko trenutaka. </p>
                    
                            <form class="space-y-4 md:space-y-6" id="registrationForm">
                                    
                                    <div class="flex space-x-4">
                                            <div class="w-1/2">
                                                    <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ime</label>
                                                    <input type="text" name="first_name" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ime" required="">
                                            </div>

                                            <div class="w-1/2">
                                                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prezime</label>
                                                    <input type="text" name="last_name" id="last_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Prezime" required="">
                                            </div>
                                    </div>

                                    <div>
                                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Vaša e-pošta</label>
                                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="imeprezime@student.foi.hr" required="">
                                    </div>
                                    <div>
                                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lozinka</label>
                                            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                                    </div>
                                    <div>
                                            <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ponovite lozinku</label>
                                            <input type="password" name="confirm_password" id="confirm_password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                                    </div>
                                    <button type="submit" id="submitButton" class="w-full text-center bg-gradient-to-r from-[#7360DF] to-[#8472E5] text-white font-bold py-2 px-6 rounded shadow-lg hover:scale-105 hover:shadow-xl transition-transform transition-colors duration-300 ease-in-out ">
                                            Registriraj se
                                    </button>
                                    <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                                            Imate li račun? <a href="<?php echo BASE_PATH ?>/login" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Prijavite se</a>
                                    </p>
                            </form>
                    </div>
            </div>
    </div>
</section>

<script>
$(document).ready(function() {
        $('#registrationForm').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                var formData = $(this).serialize();
                console.log(formData);

                // Disable the submit button
                $('#submitButton').prop('disabled', true);

                // Re-enable the submit button after 7 seconds
                setTimeout(function() {
                        $('#submitButton').prop('disabled', false);
                }, 7000);

                // Send the form data using jQuery's AJAX method
                $.ajax({
                        url: '<?php echo BASE_PATH?>/register/registerUser',
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                                if (response.status == 'success') {
                                        Swal.fire({
                                                title: 'Uspješno!',
                                                text: 'Registracija je uspješna! Sada se možete prijaviti. Ako postoje poteškoće javite se na whatsapp 0976278125 ili mail salabahter.learning@gmail.com ',
                                                icon: 'success',
                                                confirmButtonText: 'U redu',
                                                                customClass: {
                                                                        confirmButton: 'text-black'
                                                                },
                                                allowOutsideClick: false
                                        }).then((result) => {
                                                if (result.isConfirmed) {
                                                        // Redirect the user when they click "U redu"
                                                        window.location.href =
                                                                '<?php echo BASE_PATH ?>/login';
                                                }
                                        });
                                } else if (response.status == 'email_exists') {
                                        Swal.fire({
                                                title: 'Greška!',
                                                text: 'Email već postoji! Pokusajte se prijaviti!'+' Ako se greška ponavlja obratite se na salabahter.learning@gmail.com',
                                                icon: 'error',
                                                confirmButtonText: 'Okay',
                                                                customClass: {
                                                                        confirmButton: 'text-black'
                                                                },
                                                allowOutsideClick: false
                                        })
                                } else if (response.status == 'error') {
                                        Swal.fire({
                                                title: 'Greška!',
                                                text: 'Došlo je do greške prilikom registracije!'+' Ako se greška ponavlja obratite se na salabahter.learning@gmail.com',
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