<?php $this->load->view('header');?>

    <div class="container home" role="main">

		<div class="row">

			<div class="jumbotron">
				<?php if (!isset($current_user)): ?>
					<p>
						<a href="#register" data-toggle="modal" data-target="#registerModal">
							<strong>Register now!</strong>
						</a>
					</p>
				<?php else: ?>
					
					
					<ul>
						<?php 
							$xml = new SimpleXMLElement($proposicoes);
						
							foreach ($xml->xpath('//proposicao') as $item) : ?>
						<li>
							<h3><?php echo $item->nome ."\n"; ?></h3>
							<div class="btn btn-info" data-toggle="modal" data-target="#novoProjetoModal">Publicar</div>
							<p>
								<?php echo $item->txtEmenta ."\n"; ?>
							</p>
						</li>
						<?php endforeach; ?>
					</ul>
					
					
				<?php endif;?>

			</div>

		</div>
    </div>


<?php $this->load->view('footer.php');
