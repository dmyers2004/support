<div class="support-container">

	<h5>Do you need help? Ask for it here.</h5>
	<div class="support-form">
		<?php echo form_open('support/index', 'id="add-ticket"'); ?>
			<label for="name">What is your name?</label><br />
			<?php echo form_error('name', '<span class="error">', '</span>'); ?>
			<?php echo form_input('name', set_value('name')); ?>

			<label for="title">A few words about the problem. This information will be public.</label><br />
			<?php echo form_error('title', '<span class="error">', '</span>'); ?>
			<?php echo form_input('title', set_value('title')); ?>

			<label for="description">Give as many details as you like. Everything in this field is confidential.</label><br />
			<?php echo form_error('description', '<span class="error">', '</span>'); ?>
			<?php echo form_textarea('description', set_value('description')); ?>
				
			<?php echo form_submit('submit', 'Send it!'); ?>
		<?php echo form_close(); ?>
	</div>

	<div class="ticket-list">
		{{ if entries }}
		<h5>Curious? Here are the issues that we're currently working on.</h5>
			<table cellpadding="0" cellspacing="0">
				<tr>
					<th>Ticket Number</th>
					<th>Name</th>
					<th>Issue Summary</th>
					<th>Status</th>
				</tr>

				{{ entries }}
				<tr>
					<td>{{ number }}</td>
					<td>{{ name }}</td>
					{{ if user:group == 'admin' }}
						<td><a data-id="{{ id }}" class="details" href="{{ url:current }}/#">{{ title }}</a></td>
					{{ else }}
						<td>{{ title }}</td>
					{{ endif }}
					<td class="{{ id }} {{ status }}">{{ status }}</td>
				</tr>
				{{ /entries }}
			</table>
		{{ else }}
			<p>There are no tickets yet.</p>	
		{{ endif }}
	</div>

	<div class="details-display" style="display:hidden">
		<div class="inner">
			<ul>
				<li class="message"></li>
				<li class="name"><label for="name">Name:</label> <span id="name"></span></li>
				<li class="title"><label for="title">Title:</label> <span></span></li>
				<li class="created"><label for="created">Created On:</label> <span></span></li>
				<li class="status"><label for="status">Status:</label> <span></span></li>
				<li class="description"><label for="description">Description:</label> <span></span></li>
			</ul>
			<div class="details-buttons">
				<a data-status="open" class="btn orange" href="{{ url:current }}/#">Re-Open</a>
				<a data-status="in-progress" class="btn blue" href="{{ url:current }}/#">In Progress</a>
				<a data-status="resolved" class="btn green" href="{{ url:current }}/#">Resolve</a>
			</div>
		</div>
	</div>
	
</div>