<nav class="nav-main-wrap">
	<ul id="primary-menu" class="theme-main-menu">
		<% loop $Menu(1) %>
			<li class="menu-item">
				<% if $isCurrent %>
				<a class="active" aria-current="page" href="{$Link}">{$MenuTitle}</a>
				<% else %>
				<a class="" href="{$Link}">{$MenuTitle}</a>
				<% end_if %>
    		</li>
		<% end_loop %> 
	</ul>
</nav>