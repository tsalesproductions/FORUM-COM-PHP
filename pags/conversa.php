<?php $forum = new forum($con);?>
<div class="global-content">
	<div class="global-title">Convendo com <b><?php echo $explode['1'];?></b></div>
	<div class="row">
		<div class="col-sm-8 offset-2 chat-content" id="chat-content">

		<div class="mesgs" id="scroll">
      <div class="msg_history" id="history">
           <?php $forum->get_chatmessages($explode['1']);?>
			</div>

          <div class="type_msg">
            <div class="input_msg_write">
        	<form method="POST">
              <input type="text" class="write_msg" name="mensagem" placeholder="Digite uma mensagem" required />
              <button id="clicable" class="msg_send_btn" type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
              <input type="hidden" name="env" value="chat">
          	</form>
            <?php $forum->send_message_chat($explode['1']);?>
            </div>
          </div>

        </div>
		</div>
	</div>
	<br>
</div>