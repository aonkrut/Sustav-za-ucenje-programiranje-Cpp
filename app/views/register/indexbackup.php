<div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                    <a href="<?php echo BASE_PATH?>" class="tx-30 text-decoration-none tx-purple">Šalabahter</a>
                </div>
                <h4>Ovdje možete izraditi novi račun</h4>
                <h6 class="font-weight-light">Registracija je vrlo jednostavna i gotova u samo nekoliko koraka</h6>
                <form class="pt-3" id="registrationForm">
                <!-- <form class="pt-3" action="<?php echo BASE_PATH?>/register/registerUser" method="POST"> -->
                  <div class="form-group">
                    <label class="form-label">Ime</label>
                    <input type="text" class="form-control form-control-lg" id="first_name" name="first_name" placeholder="Ime">
                  </div>
                  <div class="form-group">
                    <label class="form-label">Prezime</label>
                    <input type="text" class="form-control form-control-lg" id="last_name" name="last_name" placeholder="Prezime">
                  </div>
                  <div class="form-group">
                  <label class="form-label">Email</label>
                    <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Email">
                  </div>
                  <!-- <div class="form-group">
                    <select class="form-select form-select-lg" id="exampleFormControlSelect2">
                      <option>Country</option>
                      <option>United States of America</option>
                      <option>United Kingdom</option>
                      <option>India</option>
                      <option>Germany</option>
                      <option>Argentina</option>
                    </select>
                  </div> -->
                  <div class="form-group">
                    <label class="form-label">Lozinka</label>
                    <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Lozinka">
                  </div>
                  <div class="form-group">
                     <label class="form-label">Ponovno unesite lozinku</label>
                    <input type="password" class="form-control form-control-lg" id="password2" placeholder="Ponovno unesite lozinku">
                  </div>

                  <div class="mb-4">
                  </div>

                  <div class="mt-3 d-grid gap-2">
                    <button class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">Registriraj se</button>
                  </div>
                  <div class="text-center mt-4 font-weight-light"> Već imate račun? <a href="<?php echo BASE_PATH?>/login/index" class="text-primary">Prijavite se</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>


  <script>
        $(document).ready(function() {
          $('#registrationForm').on('submit', function(event) {
              event.preventDefault(); // Prevent the default form submission

              var formData = $(this).serialize();
              console.log(formData);

              // Send the form data using jQuery's AJAX method
              $.ajax({
                  url: '<?php echo BASE_PATH?>/register/registerUser',
                  type: 'POST',
		  data: formData,
		  dataType: 'json',
                  success: function(response) {
                      if (response.status == 'success') {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Registracija je uspjesna! Na vasu email adresu stici ce code koji cete unjeti na slijedecoj lokaciji',
                            icon: 'success',
			    confirmButtonText: 'U redu',
			    allowOutsideClick: false
		      }).then((result) => {
 				 if (result.isConfirmed) {
    				// Redirect the user when they click "U redu"
					 window.location.href = '<?php echo BASE_PATH ?>/register/verification/' + response.public_id;;
  				}
			});		      	
                      } else if(response.status == 'email_exists'){
                        Swal.fire({
                            title: 'Error!',
                            text: 'An account with that email already exists',
                            icon: 'error',
			    confirmButtonText: 'Okay',
			    allowOutsideClick: false
                          })
                      }
                      else if(response.status == 'error'){
                        Swal.fire({
                            title: 'Error!',
                            text: 'Uknown Error',
                            icon: 'error',
			    confirmButtonText: 'Okay',
			    allowOutsideClick: false
                          })
                      }
                  },
              });
          });
    });
</script>

