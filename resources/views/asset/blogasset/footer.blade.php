
<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
    <div class="footer-content">
        <div class="container">

            <div class="row g-5">
                <div class="col-lg-4">
                    <h3 class="footer-heading">archive</h3>

                    {{-- <div style="overflow:hidden;">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <div id="datetimepicker12"></div>
                                </div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function () {
                                $('#datetimepicker12').datetimepicker({
                                    inline: true,
                                    sideBySide: true
                                });
                            });
                        </script>
                        </div> --}}

                        {{-- <div class='input-group date'>
                            <div id="calendar"></div>
                                  <input type='text' id='datetimepicker' class="form-control" name="publish_at"
                                    />
                        </div>
                              <script type="text/javascript">
                              // var today = new Date();
                              // document.getElementById("datetime").value = today.getFullYear() +
                              //     '-' + ('0' + (today.getMonth() + 1)).slice(-2) +
                              //     '-' + ('0' + today.getDate()).slice(-2) +
                              //     ' ' + ('0' + today.getHours()).slice(-2) +
                              //     ':' + ('0' + today.getMinutes()).slice(-2) +
                              //     ':' + ('0' + today.getSeconds()).slice(-2);
                              $(function() {
                                
                                  $('#datetimepicker').datepicker({
                                    inline: true,
                                    sideBySide: true,
                                    format: 'yyyy-mm-dd',
                                    autoclose: false,
                                    timePicker: false,
                                    todayHighlight: true,
                                  });
                              });
                          </script> --}}
                            {{-- <input type="text" class="datepicker" id="date1" value="Select First Date"/>
                            <input type="text" class="datepicker" id="date2" value="Select Last Date"/>
                            <script>
                                $(document).ready(function() {    
                                        $("input.datepicker").Zebra_DatePicker({ dateFormat: "dd-mm-yy" });
                                        
                                        $('#date1').Zebra_DatePicker({
                                            onSelect: function (date) {
                                                alert(date);
                                            }
                                        });
                                    });
                            </script> --}}   

                            
                            {{-- {!! substr_replace($about->{'content_' . app()->getLocale()}, '...', 100) !!}
                        <p><a href="{{ route('page.single', ['slug' => $about->{'slug_' . app()->getLocale()}, 'id' => $about->id]) }}" class="footer-link-more">Learn More</a></p> --}}

                    <form method="POST" id="myforms" name="archiveform"  action="{{ route('archivedate') }}" >
                        @csrf
                         
                    <div id="date_container" style="margin: 10px 0 15px 0; height: 255px; position: relative"></div>
                     <div class="well">
                        <div class="row">
                            <div class="col-sm-12">
                                  <input type="hidden" name="archive-date" id="datepicker-always"                              
                                  class="form-control celecderDispaly" style="width: 100%;">
                                  

                            </div>
                        </div>
                   </div>
                     <input type="hidden" value="submit"  class="btn btn-success" /> 
               </form>
                <script>
                   
                    $(document).ready(function () {     
                    $("input.celecderDispaly").Zebra_DatePicker({                       
                            always_visible: $("#date_container"),                            
                            onSelect: function (date) { 
                        //=====================================  JS Auto data send 
                            document.forms["archiveform"].submit();
                            date.preventDefault();
                        //================================== Ajax data send
                                //  var date = {
                                //     "archive-date": date
                                // };
                                // // alert(data);
                                //  $.ajaxSetup({
                                //     headers: {
                                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                //     }
                                // });
                                // $.ajax({
                                //     type: "POST",
                                //     url: "{{ route('archivedate') }}",
                                //     data: date,
                                //     success: function(response) {
                                //         $('#result').html(response);
                                        
                                        
                                //     }
                                // });
                            }
                        });
                   
                    });    
                </script>
                </div>
                <div class="col-6 col-lg-2">
                    <h3 class="footer-heading">Navigation</h3>
                    @php
                        $menu = DB::table('menus')
                            ->get()
                            ->toArray();
                    @endphp
                    @if (isset($menu[1]) ? $menu[1]->location == 2 : '')
                        @include('menu.footer')
                    @else
                        @if (Route::has('login'))
                            <a href="{{ route('superAdmin.menus') }}"
                                style="text-align: center;
                    display: block;
                    font-size: 22px;
                    font-weight: bold;
                    text-transform: uppercase;
                    text-decoration: underline;
                    color: red;">
                                Add Footer Menu</a>
                        @endif
                    @endif
                </div>
                <div class="col-6 col-lg-2">
                    <h3 class="footer-heading">Inportant Link</h3>
                    {{-- @php
                        $menu = DB::table('menus')
                            ->get()
                            ->toArray();
                    @endphp
                    @if (isset($menu[2]) ? $menu[2]->location == 3 : '')
                        @include('menu.sidebar')
                    @else
                        @if (Route::has('login'))
                            <a href="{{ route('superAdmin.menus') }}"
                                style="text-align: center;
                    display: block;
                    font-size: 22px;
                    font-weight: bold;
                    text-transform: uppercase;
                    text-decoration: underline;
                    color: red;">
                                Add Footer Menu</a>
                        @endif
                    @endif --}}
                    <ul class="footer-links list-unstyled">
                        <li><a href="https://www.prothomalo.com/" target="_blank"><i class="bi bi-chevron-right"></i>
                                Prothom alo</a>
                        </li>
                        <li><a href="https://www.bbc.com/bengali" target="_blank"><i class="bi bi-chevron-right"></i>
                                BBC Bangla</a>
                        </li>
                        <li><a href="https://www.aljazeera.com/" target="_blank"><i class="bi bi-chevron-right"></i>
                                Al Jazeera</a></li>
                        <li><a href="https://www.bbc.com/" target="_blank"><i class="bi bi-chevron-right"></i> BBC</a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-4">
                    <h3 class="footer-heading">Subscribe</h3>

                    {!! Form::open(['route' => 'submail', 'method' => 'POST']) !!}
                    <input type="text" name="email" placeholder="Email">
                    <button type="submit" class="btn btn-sm btn-success ">Submit</button>
                    {!! Form::close() !!}

                </div>


            </div>
        </div>
    </div>

    <div class="footer-legal">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <div class="copyright">
                        © Copyright <strong><span>webexpert</span></strong>. All Rights Reserved
                    </div>
                    <div class="credits">
                        Designed by <a href="https://webexpertaz.com/">webexpert</a>
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="social-links mb-3 mb-lg-0 text-center text-md-end">
                        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="google-plus"><i class="bi bi-skype"></i></a>
                        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>
<!-- Vendor JS Files -->
<script src="{{ asset('blogassets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('blogassets/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('blogassets/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('blogassets/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('blogassets/vendor/php-email-form/validate.js') }}"></script>
<!-- Date picker -->
    <script src="https://cdn.jsdelivr.net/npm/zebra_pin@2.0.0/dist/zebra_pin.min.js"></script>
    <script src="{{ asset('blogassets/js/zebra_datepicker.min.js') }} "></script>
    <script src="{{ asset('blogassets/js/examples.js') }} "></script>

<!-- Template Main JS File -->
<script src="{{ asset('blogassets/js/main.js') }}"></script>
<!-- Share JS -->
<script src="{{ asset('js/share.js') }}"></script>

<script>

    //  $('#date_container').datepicker({  
    //     format: 'mm/dd/yyyy',  
    // }).on('changeDate', function(e) {  
    //     console.log(e.format());  
    // }); 
    // =======================Right button click disable ===========
    // With jQuery
    // https://stackoverflow.com/questions/737022/how-do-i-disable-right-click-on-my-web-page
       @php
        if (Auth::check()) {
            $email = Auth::user()->email;
            $role_id = Auth::user()->role_id;
        }
      
        if(empty($role_id)){
        @endphp
                $(document).on({
                    "contextmenu": function (e) {
                        console.log("ctx menu button:", e.which); 
                        // Stop the context menu
                        e.preventDefault();
                        alert("Stop click right button");
                    },
                    "mousedown": function(e) { 
                        // alert("Stop click right button", e.which);
                        console.log("normal mouse down:", e.which); 
                    },
                    "mouseup": function(e) { 
                        // alert("Stop click right button", e.which);
                        console.log("normal mouse up:", e.which); 
                    }
                });
        @php
            }else if(($role_id == '1') || ($role_id == '2')) {
        @endphp
        @php
            }
        @endphp
</script>
