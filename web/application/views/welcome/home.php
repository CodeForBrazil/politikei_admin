<?php $this->load->view('header');?>

    <div class="container home" role="main">

		<div class="row">

			<div class="jumbotron">
				

				<h4 style="text-align: center;"><strong>Bem vindos ao Portal de Colaboradores do Politikei</strong></h4>
				
				<br /><br />

				<div id="faq" style="border: 1px solid black; padding: 10px;">	
					
					<h5><strong>Como fazer parte do Politikei sendo um colaborador de proposições?</strong></h5>
					<p>
						Para facilitar a sua colaboração, desenvolvemos um portal exclusivo onde você pode ver as 
						proposições que necessitam ser resumidas, acessar suas informações, reservá-las antes de 
						começar a produzi-las (para que ninguém faça trabalho em vão), e submeter o resumo realizado.
					</p>

					<h5><strong>Qual formato deve ser o resumo?</strong></h5>
				
					<p>
						O resumo deve ser de linguagem simples e clara, autoexplicativo, que contenha de forma direta 
						todas as informações de uma proposição expostas em ordem de relevância, para gerar envolvimento 
						e agilidade aos usuários.
					</p>

					<p>
						É de suma importância IMPARCIALIDADE na produção de um resumo, ou seja, não se deve emitir qualquer
						juízo de valor ou manipular as informações tornando-as tendenciosas. Estamos trabalhando juntos para
						 empoderar os cidadãos tornando-os agentes transformadores, e não para influenciá-los de nossas opiniões.
					 </p>

					<h5><strong>Por que devo preencher 2 campos para submeter um resumo?</strong></h5>

					<p>
						O primeiro (menor) está destinado a um “título” para a proposição que, em poucas palavras, identifique 
						aos usuários de qual proposição estamos nos referindo.
					</p>

					<p>
						O segundo (maior) está destinado ao resumo propriamente dito.
					</p>

					<h5><strong>Dúvidas, críticas, sugestões?</strong></h5>

					<p>
						Nunca se esqueça de que trabalhamos de forma aberta e colaborativa, por isso é muito importante para nós 
						recebermos todo tipo de opiniões. E caso queira participar de forma ainda mais ativa, fale com a gente!
					</p>

					<h5><strong>Comece agora mesmo:</strong></h5>

					<ol>
						<?php if (!isset($current_user)): ?>
							<li><a href="#register" data-toggle="modal" data-target="#registerModal">Cadastre-se</a>. em nosso portal.
							Já tem conta?<a href="#login" data-toggle="modal" data-target="#loginModal"> Clique aqui</a>.</li>
						<?php endif;?>
						<li>Escolha uma proposição disponível para resumi-la.</li>
						<li>Reserve a proposição.</li>
						<li>Produza o “título” e o resumo.</li>
						<li>Submeta-os pelo portal. </li>
					</ol>
				</div>


			</div>

		</div>
    </div>


<?php $this->load->view('footer.php');