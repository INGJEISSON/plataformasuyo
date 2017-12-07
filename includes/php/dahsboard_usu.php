<div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Dashboard</h4> </div>     
                </div>
                <!-- /.row -->
                <!-- ============================================================== -->
                <!-- Different data widgets -->
                <!-- ============================================================== -->

                <div class="row">
                    <div class="col-lg-4 col-sm-6 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title">TAREAS VENCIDAS </h3>
                            <ul class="list-inline two-part">
                                <li><i class="icon-people text-info"></i></li>
                                <li class="text-right"><span class="counter">2</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title">TAREAS PENDIENTES</h3>
                            <ul class="list-inline two-part">
                                <li><i class="icon-folder text-purple"></i></li>
                                <li class="text-right"><span class="counter">80</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title">PRÓXIMAS A VENCERSE</h3>
                            <ul class="list-inline two-part">
                                <li><i class="icon-folder text-purple"></i></li>
                                <li class="text-right"><span class="counter">10</span></li>
                            </ul>
                        </div>
                    </div>
                   
                    
                </div>

                <div class="white-box bg-theme m-b-0 p-b-0 mailbox-widget">
                            <h2 class="text-white p-b-20">Mis tareas </h2>
                            <ul class="nav customtab nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#home1" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-email"></i></span><span class="hidden-xs"> VENCIDAS</span></a></li>
                                <li role="presentation" class=""><a href="#profile1" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-export"></i></span> <span class="hidden-xs">HOY</span></a></li>
                                <li role="presentation" class=""><a href="#messages1" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-panel"></i></span> <span class="hidden-xs">PENDIENTES</span></a></li>
                                <li role="presentation" class=""><a href="#settings1" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-trash"></i></span> <span class="hidden-xs">PRÓXIMAS A VENCERSE</span></a></li>
                            </ul>
                </div>

                <div class="white-box p-0">
                            <div class="tab-content m-t-0">
                                <div role="tabpanel" class="tab-pane fade active in" id="home1">
                                    <div class="p-30">
                                        <ul class="side-icon-text pull-right">
                                            <li><a href="#"><span class="circle circle-sm bg-success di"><i class="ti-plus"></i></span><span>Nueva tarea</span></a></li>
                                            <li><a href="#"><span class="circle circle-sm bg-danger di"><i class="ti-trash"></i></span><span>Delete</span></a></li>
                                        </ul>
                                        <h3><i class="ti-email"></i>TAREAS RETRASADAS</h3>
                                    </div>
                                    <div class="inbox-center table-responsive">
                                        <table class="table table-hover">
                                            <tbody>
                                                <tr class="unread">
                                                    <td width="1">&nbsp;</td>
                                                    <td width="50" style="width: 50px">
                                                        <div class="checkbox checkbox-info m-t-0 m-b-0">
                                                            <input type="checkbox">
                                                            <label></label>
                                                        </div>
                                                    </td>
                                                    <td width="83" class="hidden-xs" style="width: 50px"><i class="fa fa-star-o"></i></td>
                                                    <td width="61" class="hidden-xs">Diagnósticos</td>
                                                    <td width="286" class="max-texts"> <a href="inbox-detail.html"><span class="label label-info m-r-10">Tienes 2 días para revisar la documentación del cliente ALEJANDRO </span></a></td>
                                                    <td width="1" class="hidden-xs"><i class="fa fa-paperclip"></i></td>
                                                    <td width="52" class="text-right">Diciembre 4 </td>
                                                    <td width="1">&nbsp;</td>
                                                </tr>
                                                <tr class="unread">
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        <div class="checkbox checkbox-info m-t-0 m-b-0">
                                                            <input type="checkbox">
                                                            <label></label>
                                                        </div>
                                                    </td>
                                                    <td class="hidden-xs"><i class="fa fa-star text-warning"></i></td>
                                                    <td class="hidden-xs">Servicios</td>
                                                    <td class="max-texts">Tienes 4 Servicios asignados que no has empezado la revisión</td>
                                                    <td class="hidden-xs"><i class="fa fa-paperclip"></i></td>
                                                    <td class="text-right">Diciembre 4</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="profile1">
                                    <div class="col-md-6">
                                        <h3>LISTA DE TAREAS EL DIA DE HOY</h3>
                                        <h4></h4>
                                    </div>
                                       <div class="clearfix"></div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="messages1">
                                    <div class="col-md-6">
                                        <h3>PROXIMAS TAREAS</h3>
                                        <h4></h4>
                                    </div>
                                    
                                    <div class="clearfix"></div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="settings1">
                                    <div class="col-md-6">
                                        <h3>COMPLETADAS</h3>
                                        <h4></h4>
                                    </div>                                   
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

            
                
            </div>