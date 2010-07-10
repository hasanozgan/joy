$(document).ready(function() {
                    $("#login").click(function() {
                        location.href = $__application.site_root+"/login";
                    });
                    $("#donate").click(function() {
                        $("#paypal").submit();
                    });

                  });
