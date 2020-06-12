
<div class="col-12 col-md-4 p-md-0 vn-320 vn-576 vn-768 vb-1024">
	<div class="box box-white boxshadow_strong">
		<div class="contenido boxpadding card">
			<div class="title">
				
			</div>
			<div class="container-fluid p-0">
				<br>
				<div class="row">
					<div class="col-md-12 p-0">
						<div class="timeline">
							<?php 

							// CON ESTA FUNCIONC CONSULTAREMOS LOS REGISTROS DE LA VITACORA //
							require 'conexion.php';
							$consultar_vitacora = $conexion->prepare("SELECT * FROM vitacora ORDER BY id DESC LIMIT 15");
							$consultar_vitacora->execute();
							$resultado = $consultar_vitacora->get_result();
							$number_vitacora = $resultado->num_rows;
							// TOMAMOS LA FECHA ACTUAL DE NUESTRO SERVIDOR
							$fecha_actual =  date("yy-m-d");

							if($number_vitacora > 0){

								// VARIABLE QUE UTILIZAREMOS PA ESCRIBIR EL TPO DE DIA 
								$texto = "";
								while($vitacora = $resultado->fetch_assoc()){
									$fecha_vitacora = $vitacora['fecha'];
									$fecha = explode(" ", $fecha_vitacora);

									// SEPARAMOS LA FECHA DEL REGISTRO DE LA VITACORA EN DIA, MES Y AÑO //
									$fecha_separada = explode("-", $fecha[0]);

									// AÑO
									$AnoVitacora = $fecha_separada[0];
									// MES
									$mesVitacora = $fecha_separada[1];
									// DIA
									$diaVitacora = $fecha_separada[2];


									$hora_separada = explode(":",$fecha[1]);
									$hora = $hora_separada[0];
									$minutos = $hora_separada[1];
									$segundos = $hora_separada[2];

									// SEPARAMOS LA FECHA DEL SERVIDOR
									$fechaServer = explode("-", $fecha_actual);

									// AÑO
									$AnoActual = $fechaServer[0];
									// MES
									$MesActual = $fechaServer[1];
									// DIA
									$DiaActual = $fechaServer[2];

									// <!-- EN CASO CONTRARIO DE QUE LAS FECHAS SEAN DIFERENTES ENTONCES MOSTRAMOS EL DIA AL QUE CORRESPONDE SEGUN LOS CALCULOS  -->

									// CONFIGURAMOS LA HORA //

									if($hora > 12){
										$hora = $hora-12;
										$indicador = "PM";
									} else {
										$indicador = "AM";
										if($hora == 00){
											$hora = $hora+12;
										}
									}
									$hora_texto = $hora.':'.$minutos.' '.$indicador;

									// <!-- SI EL AÑO ES IGUAL SE PROSIGUE 
									// SI EL AÑO ES DIFERENTE SE MUESTRA QUE LA VITACORA PERTENECE AL AÑO ANTERIOR -->
									if($AnoActual == $AnoVitacora){

											/*SI EL MES ES IGUAL SE PROSIGUE 
											SI EL MES ES DIFERENTE SE MUESTRA QUE LA VITACORA PERTENECE AL MES ANTERIOR */
											if($MesActual == $mesVitacora){
												/*SI EL DIA ES IGUAL SE PROSIGUE 
												SI EL MES ES DIFERENTE SE MUESTRA QUE LA VITACORA PERTENECE AL MES ANTERIOR */
													if($diaVitacora == $DiaActual){
														if($texto != "Hoy"){
															$texto = "Hoy";
															?>
															<div class="time-label" style="margin-left:10px">
																<span class="bg-danger text-white"><?php echo $texto ?></span>
															</div>
															<?php
														}
													 } else {
													 	$calcularDia = $DiaActual-$diaVitacora;
															if($calcularDia == 1){
																if($texto != "Ayer"){
																$texto = "Ayer";
																?>
																<div class="time-label" style="margin-left:10px">
																	<span class="bg-success text-white"><?php echo $texto ?></span>
																</div>
																<?php
																}
															 } else {
															 	if($texto != $calcularDia." dias"){
																	$texto = $calcularDia." dias";
																	?>
																	<div class="time-label" style="margin-left:10px">
																		<span class="bg-warning text-white"><?php echo $texto ?></span>
																	</div>
																	<?php
																}
													 		}
													 }
											} else {
												if($texto != "Mes Anterior"){
												$texto = "Mes Anterior";
												?>
												<div class="time-label" style="margin-left:10px">
													<span class="bg-primary text-white"><?php echo $texto ?></span>
												</div>
												<?php
												}
											} 
									} else { 
										if($texto != "Año Anterior"){
										$texto = "Año Anterior";
										?>
										<div class="time-label" style="margin-left:10px">
											<span class="bg-primary text-white"><?php echo $texto ?></span>
										</div>
										<?php
										}
									} 
									

									// <!-- // DETERMINADOS EL MOVMIENTO REALIZADO PARA SABER QUE HA REALIZADO EL ADMINISTRADOR  -->
									
										$movimiento = $vitacora['movimiento'];
										$tipo_movimiento = explode("_", $movimiento);
										$accion = $tipo_movimiento[0];
										$tipo = $tipo_movimiento[1];
						

									// <!-- AHORA QUE YA TEMENOS LOS MOVIMIENTOS ESTABLECEMOS EL COLOR DE LA ACCION Y EL ICONO -->
									
										if($accion == "registro"){
											$colorIcono = "bg-primary";
										} else if($accion == "eliminar"){
											$colorIcono = "bg-danger";
										} else if($accion == "editar"){
											$colorIcono = "bg-success";
										} else if($accion == "agregar"){
											$colorIcono = "bg-warning";
										} else if($accion == "desbloquear"){
											$colorIcono = "bg-primary";
										} else if($accion == "bloquear"){
											$colorIcono = "bg-dark text-white";
										}


										if($tipo == "cargo"){
											$icono = "icon-doc-text";
										} 
										if ($tipo == "personal" && $accion == "desbloquear"){
											$icono = 'icon-unlock-alt';
										} 
										if ($tipo == "personal" && $accion == "bloquear"){
											$icono = 'icon-lock';
										} 
										if($tipo == "personal"){
											$icono = "icon-user";
										} 
										if($tipo == "admin"){
											$icono = "icon-user-secret";
										} 
										if($tipo == "faltas"){
											$icono = "icon-alert";
										} 
										if($tipo == "entrada"){
											$icono = "icon-newspaper-o";
										}
									 ?>	
									<?php 

									// SEPARAMOS EL TEXTO //
									$movimiento = explode("_", $vitacora['movimiento']);

									// SI ES DE TIPO REGISTRO, EDICION, ELIMINACION
									$tipo_movimiento = $movimiento[0];

									// A QUIEN VA DIRIGIDO
									$razon_movimeiento = $movimiento[1];
									if($tipo_movimiento == "registro"){
										$texto_movimiento = "Ha registrado un nuevo ".$razon_movimeiento;
									} else if($tipo_movimiento == "editar"){
										$texto_movimiento = "Ha editado un ".$razon_movimeiento;
									} else if($tipo_movimiento == "eliminar"){
										$texto_movimiento = "Ha eliminado un ".$razon_movimeiento;
									} else if($tipo_movimiento == "descartar"){
										$texto_movimiento = "Ha descartado un ".$razon_movimeiento;
									} else if($tipo_movimiento == "bloquear"){
										$texto_movimiento = "Ha bloqueado un ".$razon_movimeiento;
									} else if($tipo_movimiento == "desbloquear"){
										$texto_movimiento = "Ha desbloqueado un ".$razon_movimeiento;
									}



									 ?>

										<div>
											<i class="icon <?php echo $icono ?> <?php echo $colorIcono ?>"></i>
											<div class="timeline-item relative">
												<span class="time" style="position: absolute;bottom:0;right:0; color:black; font-size:16px;">
													<i class="icon-clock-o"></i>
													<?php echo $hora_texto ?>
												</span>

												<?php 
													$consultar_admin= $conexion->prepare("SELECT * FROM admins WHERE correo = '".$vitacora['admin']."' ");
													$consultar_admin->execute();
													$resultado_admin = $consultar_admin->get_result();
													$admin = $resultado_admin->fetch_assoc();
												 ?>

												<h3 class="timeline-header pb-3">
													<div class="container-fluid p-0">
														<div class="row p-0">
															<div class="col-2">
																<img src="fotos/<?php echo $admin['foto']?>" class="avatar-small avatar-radius">
															</div>
															<div class="col-10" style="padding-right: 25px; padding-left: 25px;">
																<!-- // CONSULTAMOS LOS DATOS DEL ADMINISTRADOR COMO NOMBRE E IMAGEN -->
																<a href="#" title=""><?php echo $admin['nombre'] ?></a>
																<p><?php echo $texto_movimiento ?></p>
															</div>
														</div>
													</div>
												</h3>
												<div class="timeline-body" style="display:none">
													Alberto mesas ha registrado a: 
													<div>
														<img src="fotos/<?php echo $admin['foto']?>" class="avatar-small avatar-radius" alt="">
														<a href="#">Jugio Guanipa</a>
													</div>
												</div>
												<div class="timeline-footer" style="display:none;">
													<a href="#" class="btn btn-primary" title="">Visitar Perfil</a>
												</div>
											</div>
										</div>
								<?php } ?>
							<?php } else { ?>

							<?php } ?>
						</div> 
						<!-- Este es el end del cuadro de la vitacora  -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>