<script>
	import Logo from '$lib/img/logo2.webp';

	const FORM_ENDPOINT = 'https://public.herotofu.com/v1/f13130f0-396f-11ee-b9b4-c111e90b930c'; // TODO - update to the correct endpoint

	
</script>

<style lang="scss">
	@import './_contact_form.scss';
</style>

<div class="contact__form">
		<div class="header">
			<div class="logo">
				<img src={Logo} alt="White S letter on black background">
			</div>
			<div class="title">
				<h1>Contact us..
				</h1>
			</div>
		</div>
		<form action="https://public.herotofu.com/v1/f13130f0-396f-11ee-b9b4-c111e90b930c" method="post" accept-charset="UTF-8" id="form1">

			<div class="input__container">
				<label for="name">Name</label>
				<input type="text" name="contactName" placeholder=" " required>
				<span>Name</span>
			</div>

			<div class="input__container">
				<label for="email">Email</label>
				<input type="email" name="contactEmail" placeholder=" " required>
				<span>Email</span>
			</div>

			<div class="input__container">
				<label for="subject">Subject</label>
				<input type="text" name="contactSubject" placeholder=" " required>
				<span>Subject</span>
			</div>

			<input type='hidden' name='honeypot' id='honeypot' />

			<div class="input__container">
				<label for="message">Message</label>
				<textarea name="contactMessage" placeholder=" " cols="48" rows="8" required></textarea>
				<span>Message</span>
			</div>

		</form>
		<div class="bottom">
			<input type="reset" value="Cancel" class="cancel__button" form="form1">
			<input type="submit" value="Send" class="main__button" form="form1">
			<div style="text-indent:-99999px; white-space:nowrap; overflow:hidden; position:absolute;" aria-hidden="true">
				<input type="text" name="_gotcha" tabindex="-1" autocomplete="off" />
			</div>
		</div>
	</div>
