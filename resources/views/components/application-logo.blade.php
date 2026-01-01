<style>
	@font-face{
		font-family: 'CrooglaLocal';
		src: url('/fonts/fonnts.com-croogla_4f-medium.otf') format('opentype');
		font-weight: 600;
		font-style: normal;
		font-display: swap;
	}
	.application-logo-text{
		color: #F2B705;
		font-family: 'CrooglaLocal', 'Croogla Medium', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
		font-weight: 700;
		font-size: 2.5rem;
		line-height: 1;
		display: block;
		text-align: center;
		width: 100%;
	}
</style>

<span {{ $attributes->merge(['class' => 'application-logo-text']) }} aria-label="zappp.eu">zappp.eu</span>
