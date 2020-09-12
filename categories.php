<?php
include_once "connection.php";
require('top.inc.php');
if (!isset($currentlyLoggedInAdmin) || !$currentlyLoggedInAdmin || !isset($currentlyLoggedInUser) || !$currentlyLoggedInUser) {
    header("Location:index.php");
    exit();
}
?>
<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Categorys </h4>
                        <h4 class="box-link"><a href="" data-toggle="modal" data-target="#addModal">Add category
                            </a> </h4>
                        </li>
                    </div>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th class="serial">#</th>
                                        <th>ID</th>
                                        <th>status</th>
                                        <th>Name</th>
                                        <th>createdBy</th>
                                        <th>createdOn</th>
                                        <th>UpdatedOn</th>
                                        <th>actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = mysqli_query($conn, "SELECT * FROM `category`");
                                    if ($result) {
                                        $count = 1;
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $typeId = $row["id"];
                                                $status = $row["status"];
                                                $name = $row["value"];
                                                $createdBy = $row["createdBy"];
                                                $createdOn = $row["createdOn"];
                                                $updated = $row["updatedOn"];
                                                $actionClassname = ["delete", "complete"];
                                                $actionName = ["Deleted", "Active"];
                                                // <span class="badge badge-complete">Active</span>
                                                // <span class="badge badge-delete">Deleted</span>
                                                echo '
                <tr class="each-row" data-id="' . $typeId . '">
                    <td class="serial">' . $count . '</td>
                    <td>' . $typeId . '</td>
                    <td><span class="badge badge-' . $actionClassname[$status] . '">' . $actionName[$status] . '</span></td>
                    <td>' . $name . '</td>
                    <td>' . $createdBy . '</td>
                    <td>' . $createdOn . '</td>
                    <td>' . $updated . '</td>
                    <td>
                        <span
                            class="badge badge-edit"><a
                                href="">Edit</a></span>
                        <span
                            class="badge badge-delete"><a
                                href="">Delete</a></span>
                    </td>
                </tr>';
                                                $count += 1;
                                            }
                                        }
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Category</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="categories" class=" form-control-label">Category</label>
                        <input type="text" name="categories" id="addCategoryInput" placeholder="Enter category name" class="form-control" required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="add-category-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
                        <span id="payment-button-amount">Add</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="categories" class=" form-control-label">Category</label>
                        <input type="text" name="categories" id="editCategoryInput" placeholder="Enter category name" class="form-control" required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="edit-category-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
                        <span id="payment-button-amount">Save</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to <b>Delete <span id="deleteItemName"></span>?</b> .</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" id="deleted-category-Button" type="button" data-dismiss="modal">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    require('footer.inc.php');
    ?>
    <script>
        console.log("baba no my name say ma ko lo");
        jQuery(document).ready(($) => {
            let activelySelectedId = null;
            console.log("baba no my name say ma ko lo 345790");
            //badge-edit,badge-delete,each-row
            $(document).on('click', ".badge.badge-delete", (event) => {
                event.preventDefault();
                let currentRow = $(event.target).parents(".each-row");
                let id = currentRow.data("id");
                if (!isNaN(id) && id > -1 && Number.isInteger(id)) {
                    activelySelectedId = id;
                    $("#deleteItemName").text(currentRow.find("td:nth(3)").text());
                    $("#deleteModal").modal();
                } else {
                    alert("identifier not found");
                }
            });
            $(document).on('click', ".badge.badge-edit", (event) => {
                event.preventDefault();
                let currentRow = $(event.target).parents(".each-row");
                let id = currentRow.data("id");
                if (!isNaN(id) && id > -1 && Number.isInteger(id)) {
                    activelySelectedId = id;
                    $("#editCategoryInput").val(currentRow.find("td:nth(3)").text());
                    $("#editModal").modal();
                } else {
                    alert("identifier not found");
                }
            });
            $(document).on('click', "#deleted-category-Button", (event) => {
                event.preventDefault();
                let manageCategoryId = activelySelectedId;
                if (!Number.isInteger(Number(manageCategoryId)) || !manageCategoryId.toString().length) {
                    alert("Please invalid identifier");
                } else {
                    let data = {
                        manageCategoryId: activelySelectedId,
                        action: "deleted-category"
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
                            body: JSON.stringify(
                                data), // body data type must match "Content-Type" header
                            //body
                        })
                        .then((res) => res.json())
                        .then((json) => {
                            if (json.success) {
                                alert(json.message);
                                window.location.href = window.location.href;
                            } else {
                                alert(json.message || "Error preocessing request");
                            }
                        }).catch((error) => {
                            console.log("error", error);
                        });
                }
            });
            $(document).on('click', "#edit-category-button", (event) => {
                event.preventDefault();
                let manageCategory = $("#editCategoryInput").val();

                if (!manageCategory || typeof manageCategory != "string" || manageCategory.length < 2) {
                    alert("Please input category number");
                } else {
                    let data = {
                        manageCategory,
                        manageCategoryId: activelySelectedId,
                        action: "edit-category"
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
                            body: JSON.stringify(
                                data), // body data type must match "Content-Type" header
                            //body
                        })
                        .then((res) => res.json())
                        .then((json) => {
                            if (json.success) {
                                alert(json.message);
                                window.location.href = window.location.href;
                            } else {
                                alert(json.message || "Error preocessing request");
                            }
                        }).catch((error) => {
                            console.log("error", error);
                        });
                }
            });
            $(document).on('click', "#add-category-button", (event) => {
                event.preventDefault();
                let manageCategory = $("#addCategoryInput").val();

                if (!manageCategory || typeof manageCategory != "string" || manageCategory.length < 2) {
                    alert("Please input manageCategory number");
                } else {
                    // let data = new FormData();
                    // data.append("pname", pname);
                    // data.append("price",price);
                    // data.append("pcat",pcat);
                    // data.append("pdetails",pdetails);
                    // data.append("reg_bp", "");

                    //let body = Object.keys(data).map(key=>`${encodeURIComponent(key)}=${encodeURIComponent(data[key])}`).join("&");

                    let data = {
                        manageCategory,
                        action: "add-category"
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
                            body: JSON.stringify(
                                data), // body data type must match "Content-Type" header
                            //body
                        })
                        .then((res) => res.json())
                        .then((json) => {
                            if (json.success) {
                                alert(json.message);
                                window.location.href = window.location.href;
                            } else {
                                alert(json.message || "Error preocessing request");
                            }
                        }).catch((error) => {
                            console.log("error", error);
                        });
                }
            });
        });
    </script>
    </body>

    </html>