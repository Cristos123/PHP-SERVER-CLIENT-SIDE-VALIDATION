<?php
include_once "connection.php";
require('top.inc.php');
if (!isset($currentlyLoggedInAdmin) || !$currentlyLoggedInAdmin || !isset($currentlyLoggedInUser) || !$currentlyLoggedInUser) {
    header("Location:index.php");
    exit();
}
?>
<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header text-center">
                            <h4>Add Size</h4>
                        </div>
                        <form>
							<div class="card-body card-block">
							   <div class="form-group">
									<label for="categories" class=" form-control-label">Size</label>
									<input type="text" name="categories" id="sizeInput" placeholder="Enter size name" class="form-control" required />
								</div>
							   <button id="sizeButton" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
							   <span id="payment-button-amount">Submit</span>
							   </button>
							  
							</div>
						</form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         

    <script>
        $(document).ready(() => {
            $(document).on('click', "#sizeButton", (event) => {
                event.preventDefault();
                let size = $("#sizeInput").val();

                if (!size || typeof size != "string" || size.length < 2) {
                    alert("Please input size number");
                } else {
                    // let data = new FormData();
                    // data.append("pname", pname);
                    // data.append("price",price);
                    // data.append("pcat",pcat);
                    // data.append("pdetails",pdetails);
                    // data.append("reg_bp", "");

                    //let body = Object.keys(data).map(key=>`${encodeURIComponent(key)}=${encodeURIComponent(data[key])}`).join("&");

                    let data = {
                        size,
                        action: "add-size"
                    };
                    fetch("userserver.php", {
                            method: 'POST', // *GET, POST, PUT, DELETE, etc.
                            mode: 'cors', // no-cors, *cors, same-origin
                            cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
                            credentials: 'same-origin', // include, *same-origin, omit
                            headers: {
                                'Content-Type': 'application/json'
                                //'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            redirect: 'follow', // manual, *follow, error
                            referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
                            body: JSON.stringify(data), // body data type must match "Content-Type" header
                            //body
                        })
                        .then((res) => res.json())
                        .then((json) => {
                            if (json.success) {
                                alert(json.message);
                                window.location.href = "sizes.php" || window.location.href;
                            } else {
                                alert(json.message || "Error adding product user");
                            }
                        }).catch((error) => {
                            console.log("error", error);
                        });
                }
            });
        });
    </script>
<?php
require('footer.inc.php');
?>