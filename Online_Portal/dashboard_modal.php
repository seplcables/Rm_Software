
        <div class="modal fade" id="create" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" align="center">
                    <div class="modal-header text-center bg-info bg-gradient text-white">
                        
                        
                        <h3 class="h4 text-center">PRODUCT DETAILS</h3>
                        
                        <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <!-- <form action="#" method="POST"  > -->
                        <div class="modal-body" id="t_body_create" style="height:800px; overflow: auto;">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closebtn" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" name="savee" class="btn btn-primary savee" onclick="return checkQnty(this);">Save</button> -->
                        </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>


        <div class="modal fade" id="createitem" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
            <div class="modal-dialog modal-lg modallg">
                <div class="modal-content" align="center">
                    <div class="modal-header text-center bg-secondary text-white">
                        <h3 class="h4 text-center">ITEM DETAILS</h3>
                        <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <!-- <form action="#" method="POST"  > -->
                        <div class="modal-body" id="t_body_createitem" style="height:800px; overflow: auto;">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closebtn" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" name="savee" class="btn btn-primary savee" onclick="return checkQnty(this);">Save</button> -->
                        </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>

        <!---------pending po------------->
        <div class="modal fade" id="creatependingpo" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" align="center">
                    <div class="modal-header text-center bg-light bg-gradient text-black">
                        <h3 class="h4 text-center">PENDING PO LIST</h3>
                        <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <!-- <form action="#" method="POST"  > -->
                        <div class="modal-body" id="t_body_createpo" style="height:800px; overflow: auto;">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closebtn" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" name="savee" class="btn btn-primary savee" onclick="return checkQnty(this);">Save</button> -->
                        </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>


        <div class="modal fade" id="creatependingpoitem" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 800px;">
                <div class="modal-content" align="center">
                    <div class="modal-header text-center bg-info text-white">
                        <h3 class="h4 text-center">PENDING PO ITEM LIST</h3>
                        <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <!-- <form action="#" method="POST"  > -->

                        <h5>Po No. -<span id="pono" class="mx-2"></span></h5>
                        <div class="modal-body" id="t_body_createpoitem" style="height:auto; overflow: auto;">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closebtn" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" name="savee" class="btn btn-primary savee" onclick="return checkQnty(this);">Save</button> -->
                        </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
        <!------end--------------->

        <!------------qnty miss match-------------->
        <div class="modal fade" id="createqtymissmatch" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" align="center">
                    <div class="modal-header text-center bg-light bg-gradient text-black">
                        <h3 class="h4 text-center">PO QNTY MISS MATCH</h3>
                       <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close">X</button>

                    </div>
                    <!-- <form action="#" method="POST"  > -->
                        <div class="modal-body" id="t_body_createqtymissmatch" style="height:800px; overflow: auto;">

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closebtn" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" name="savee" class="btn btn-primary savee" onclick="return checkQnty(this);">Save</button> -->
                        </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
        <!-----------------end------------------->

        <!------------rate miss match-------------->
        <div class="modal fade" id="createratemissmatch" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" align="center">
                    <div class="modal-header text-center bg-light bg-gradient text-black">
                        <h3 class="h4 text-center">PO RATE MISS MATCH</h3>
                        <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <!-- <form action="#" method="POST"  > -->
                        <div class="modal-body" id="t_body_createratemissmatch" style="height:800px; overflow: auto;">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closebtn" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" name="savee" class="btn btn-primary savee" onclick="return checkQnty(this);">Save</button> -->
                        </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
        <!-----------------end------------------->

        <!------------Late Delivery po-------------->
        <div class="modal fade" id="createlatedelPO" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" align="center">
                    <div class="modal-header text-center bg-light bg-gradient text-black">
                        <h3 class="h4 text-center">PO LATE DELIVERY</h3>
                        <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <!-- <form action="#" method="POST"  > -->
                        <div class="modal-body" id="t_body_createlatedelpo" style="height:800px; overflow: auto;">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closebtn" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" name="savee" class="btn btn-primary savee" onclick="return checkQnty(this);">Save</button> -->
                        </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
        <!-----------------end------------------->

        <!------------Pending Approval-------------->
        <div class="modal fade" id="createpenapproval" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width:1500px;">
                <div class="modal-content" align="center">
                    <div class="modal-header text-center bg-light bg-gradient text-black">
                        <h3 class="h4 text-center">PO PENDING APPROVAL</h3>
                        <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <!-- <form action="#" method="POST"  > -->
                        <div class="modal-body" id="t_body_createpenapv" style="height:auto; overflow: auto;">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closebtn" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" name="savee" class="btn btn-primary savee" onclick="return checkQnty(this);">Save</button> -->
                        </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
        <!-----------------end------------------->


        <!------------Pending MRS-------------->
        <div class="modal fade" id="createpenmrs" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width:1500px;">
                <div class="modal-content" align="center">
                    <div class="modal-header text-center bg-light bg-gradient text-black">
                        <h3 class="h4 text-center">PO PENDING MRS</h3>
                        <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <!-- <form action="#" method="POST"  > -->
                        <div class="modal-body" id="t_body_createpenmrs" style="height:auto; overflow: auto;">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closebtn" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" name="savee" class="btn btn-primary savee" onclick="return checkQnty(this);">Save</button> -->
                        </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
        <!-----------------end------------------->

        <!-------------ve Stock Modal-------------->
        <div class="modal fade" id="createnegetivestock" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width:1500px;">
                <div class="modal-content" align="center">
                    <div class="modal-header text-center bg-light bg-gradient text-black">
                        <h3 class="h4 text-center">-VE Stock List</h3>
                        <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <!-- <form action="#" method="POST"  > -->
                        <div class="modal-body" id="t_body_createnegetivestock" style="height:auto; overflow: auto;">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closebtn" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" name="savee" class="btn btn-primary savee" onclick="return checkQnty(this);">Save</button> -->
                        </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
        <!-----------------end------------------->


        