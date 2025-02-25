<section class="bg-gray-50 dark:bg-gray-900">
  <div class="flex flex-col items-center justify-center px-2 py-1 mx-auto md:h-screen lg:py-0">
      <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
          <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
              <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                  Prijavite se 
              </h1>
            
              <form class="space-y-4 md:space-y-6" id="loginForm">
                  

                  <div>
                      <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Vaša e-pošta</label>
                      <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="ime@gmail.com" required="">
                  </div>
                  <div>
                      <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lozinka</label>
                      <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                  </div>
                  
                  <button type="submit" class="w-full text-center bg-gradient-to-r from-[#7360DF] to-[#8472E5] text-white font-bold py-2 px-6 rounded shadow-lg hover:scale-105 hover:shadow-xl transition-transform transition-colors duration-300 ease-in-out ">
                      Prijavi se
                  </button>
                    <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        Nemate račun? <a href="<?php echo BASE_PATH ?>/register" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Registriraj se</a>
                    </p>
              </form>
          </div>
      </div>
  </div>
</section>

<script>
    $(document).ready(function() {
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            console.log(formData);

            $.ajax({
                url: '<?php echo BASE_PATH?>/login/loginUser',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Uspješno ste prijavljeni',
                            showConfirmButton: false,
                                customClass: {
                                    confirmButton: 'text-black'
                                },
                            timer: 1500
                        });
                        setTimeout(function() {
                            window.location.href = '<?php echo BASE_PATH ?>/home';
                        }, 1500);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Greška',
                            text: response.message+'Ako se greška ponavlja obratite se na info@salabahter.eu'
                        });
                    }
                }
            });
        });
    });
</script>

