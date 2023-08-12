 <!-- Include Header -->
 <?php
    include('./inc/header.php');
  ?>

  <!-- contact section -->
  <section class="contact_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>Get In <span>Touch</span></h2>
      </div>
      <div class="row">
        <div class="col-md-6 px-0">
          <div class="form_container">
            <form action="">
              <div class="form-row">
                <div class="form-group col">
                  <input type="text" class="form-control" placeholder="Your Name" />
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-lg-6">
                  <input type="text" class="form-control" placeholder="Phone Number" />
                </div>
                <div class="form-group col-lg-6">
                  <select name="" id="" class="form-control wide">
                    <option value="">Select Service</option>
                    <option value="">Service 1</option>
                    <option value="">Service 2</option>
                    <option value="">Service 3</option>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col">
                  <input type="email" class="form-control" placeholder="Email" />
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col">
                  <input type="text" class="message-box form-control" placeholder="Message" />
                </div>
              </div>
              <div class="btn_box">
                <button>
                  SEND
                </button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-6 px-0">
          <div class="map_container">
            <div class="map">
              <div id="googleMap"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end contact section -->

   <!-- Include Footer -->
   <?php
    include('./inc/footer.php');
  ?>