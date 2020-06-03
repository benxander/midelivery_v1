				</div> <!-- fin #content -->
			</div> <!-- fin bg-content -->
			<div id="accesosDirectos" class="clear"></div>
			<footer>
				<? $arrFooter = get_piepagina();
					foreach ($arrFooter as $key => $value) {
						$footer[$value['nombre']] = $value['valor'];
					}
				?>
				<div id="datosContactoFooter" class="row">

					<div class="email"><i class="fa fa-envelope-o"></i>
						<span>
						<? $attr = array('style' => 'text-decoration:none; color:#fff; font-weight:bold');?><?=safe_mailto($footer['email_contacto'], $footer['email_contacto'], $attr);?>
						</span>
					</div>

					<div class="direccion"><i class="fa fa-map-marker"></i>
						<span>
							<?if(!empty($footer['url_mapa'])): ?>
								<a href="<?=$footer['url_mapa']?>" target="_blank"><?=$footer['direccion']?></a>
							<?else:?>
								<?=$footer['direccion']?>
							<?endif;?>
						</span>
					</div>

					<div class="tlf">
						<i class="fa fa-phone"></i><span><?=$footer['telefono']?></span>
					</div>

					<div class="socialLinks">
						<i class="fa fa-globe"></i>
						<div class="desta">
							<ul>
								<li>
								<a style="padding-right: 10px;" href="<?=$footer['facebook']?>" target='_blank'><img src='<?= base_url();?>images/1x1.png' id="fb" class='sprite tamano_red_social'></a>&nbsp;&nbsp;&nbsp;
								<a style="padding-right: 10px;" href="<?=$footer['twitter']?>" target='_blank'><img src='<?= base_url();?>images/1x1.png' id="tw" class='sprite tamano_red_social'></a>&nbsp;&nbsp;&nbsp;
								<a style="padding-right: 10px;" href="<?=$footer['youtube']?>" target='_blank'><img src='<?= base_url();?>images/1x1.png' id="yt" class='sprite tamano_red_social'></a>&nbsp;&nbsp;&nbsp;
								<a href="<?=base_url().get_redes("rss")['url'];?>" target='_blank'><img src='<?= base_url();?>images/1x1.png' id="rss" class='sprite tamano_red_social'></a>&nbsp;&nbsp;&nbsp;
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div id="creditos">
					<div class="center">
						<p><a rel="shadowbox;width=600;height=400;" href="<?=site_url('aviso-legal')?>">Aviso Legal</a> - &copy; <?=date('Y')?> <?=NOMBRE_PORTAL_MINUSCULAS?> - <? if ($this->session->userdata('logged')): ?><a href="<?=site_url('admin')?>">Mi Panel</a><?else:?><a href="<?=site_url('admin')?>">Login</a><? endif; ?> - Diseño web: <a href="http://www.hementxe.com">Hementxe Comunicacion</a></p>

						<!--<a href="/es/sitemap/">Sitemap</a>--><br>

					</div>


				</div>
				<a href="#arriba" id="toTop" class="flecha scroll"><i class="fa fa-chevron-up"></i></a>
			</footer>
		</div><!-- #container -->
		<!-- Google translate -->
		<style>
			footer{background-image: url(<?=base_url() . 'uploads/' . get_imagen("bg_footer")?>)}
		</style>


		<script type="text/javascript" src="<?=base_url();?>js/jquery.cookiesdirective.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				// Cookie setting script wrapper
				var cookieScripts = function () {
					// Internal javascript called
					console.log("Running");
					// Loading external javascript file
					$.cookiesDirective.loadScript({
						uri:'external.js',
						appendTo: 'eantics'
					});
				}

				$.cookiesDirective({
					explicitConsent: false,
					duration: 10,
					backgroundOpacity: '90',
					privacyPolicyUri: 'politica-de-cookies',
					inlineAction: true,
					message: '<div style="font-size:1.5em"><b>ATENCION</b></div>',
					multipleCookieScriptBeginningLabel: ' Este sitio usa scripts de ',
					and: ' y ',
					multipleCookieScriptEndLabel: ' los cuales emplean cookies.',
					impliedSubmitText: 'OK',
					impliedDisclosureText: ' Para más información, vea nuestra ',
					// explicitFindOutMore: 'Para más información, vea nuestra ',
					// explicitCookieAcceptanceLabel: 'Entiendo y Acepto. ',
					// explicitCheckboxLabel: 'Debes seleccionar la casilla "Entiendo y Acepto" ',
					// explicitCookieAcceptButtonText: ' OK ',
					position : 'bottom',
					cookieScripts: ' google, google translate, session',
					scriptWrapper: cookieScripts,


					privacyPolicyLinkText: ' politica de cookies',
					backgroundColor: 'rgb(56, 169, 163)',
					linkColor: '#FDC609',

					explicitCookieDeletionWarning: ' Tu puedes borrar los cookies.<br>'
				});
			});
		</script>
		<?=$scripts?>
    </body>
</html>