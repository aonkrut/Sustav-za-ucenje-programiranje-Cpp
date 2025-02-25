<?php if ($redirect == 'id_error') {
  header("Location: ../index.php");
} ?>
<section class="bg-gray-50 dark:bg-gray-900">
  <div class="flex flex-col items-center justify-center px-2 py-1 mx-auto md:h-screen lg:py-0">
    <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
      <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
          Potvrdite svoj račun
        </h1>
        <p class="mt-1.5 text-sm text-red-500" >Moguće je da registracija ne radi ispravno, zbog poteškoća sa serverom. Javi se na whatsapp 0976278125 ili mail salabahter.learning@gmail.com </p>
        <p class="text-sm font-light text-gray-500 dark:text-gray-400">
          Unesite verifikacijski kod koji ste dobili na email
        </p>
        <form class="space-y-4 md:space-y-6" id="verificationForm">
          <!-- <form class="pt-3" action="<?php echo BASE_PATH ?>/register/registerUser" method="POST"> -->
          <div class="form-group">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unesite verifikacijski kod</label>
            <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="code" name="code" placeholder="KOD">
          </div>

          <input type="text" value="<?php echo $public_id; ?>" name="id" hidden>
          <div class="mt-3 d-grid gap-2">
            <button class="w-full text-center bg-gradient-to-r from-[#7360DF] to-[#8472E5] text-white font-bold py-2 px-6 rounded shadow-lg hover:scale-105 hover:shadow-xl transition-transform transition-colors duration-300 ease-in-out ">Aktiviraj račun</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>


<script>
  $(document).ready(function() {
    $('#verificationForm').on('submit', function(event) {
      event.preventDefault(); // Prevent the default form submission

      var formData = $(this).serialize();
      console.log(formData);

      // Send the form data using jQuery's AJAX method
      $.ajax({
        url: '<?php echo BASE_PATH ?>/register/verifyUser',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
          if (response.status == 'success') {
            Swal.fire({
              title: 'Uspjesno!',
              text: 'Aktivacija računa je uspješna, sada se možete prijaviti!',
                icon: 'success',
                confirmButtonText: 'U redu',
                customClass: {
                confirmButton: 'bg-black text-white'
                }
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.href = '<?php echo BASE_PATH ?>/login';
              }
            })
          } else if (response.status == 'wrong_code') {
            Swal.fire({
              title: 'Error!',
              text: 'Unjeli ste pogresan verifikacijski kod! Ako se greška ponavlja kontaktirajte nas: salabahter.learning@gmail.com',
              icon: 'error',
              confirmButtonText: 'Okay',
                customClass: {
                confirmButton: 'bg-black text-white'
                }
            })
          } else if (response.status == 'code_expiered') {
            Swal.fire({
              title: 'Error!',
              text: 'Vas kod je isteako, zatrazite novi',
              icon: 'error',
              confirmButtonText: 'Okay',
                customClass: {
                confirmButton: 'bg-black text-white'
                }
            })
          }
        },
      });
    });
  });
</script>