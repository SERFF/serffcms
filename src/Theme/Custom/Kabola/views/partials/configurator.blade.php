<div class="section">
    <div class="configurator-content">
        <h1>{!! translate('kabola.configurator.which_boiler_suits_me') !!}</h1>
        <p>{!! translate('kabola.configurator.intro_text') !!}</p>
        <h3>{!! translate('kabola.configurator.application') !!}</h3>
        <form action="{{ route('configurator.calculate') }}" method="post">
							<span id="application">
								<input type="checkbox" id="CentralHeating" value="centralheating" name="application[]">
								<label for="CentralHeating">{!! translate('kabola.configurator.central_heating') !!}</label>
								<input type="checkbox" id="HotWater" value="hotwater" name="application[]">
								<label for="HotWater">{!! translate('kabola.configurator.hot_water') !!}</label>
								<input type="checkbox" id="HotAir" value="hotair" name="application[]">
								<label for="HotAir">{!! translate('kabola.configurator.hot_air') !!}</label>
								<input type="checkbox" id="Airco" value="airco" name="application[]">
								<label for="Airco">{!! translate('kabola.configurator.airconditioning') !!}</label>
							</span>
            <span id="heatingspace">
								<h3>{!! translate('kabola.configurator.heating_space') !!}</h3>
								<input type="number" placeholder="{!! translate('kabola.configurator.heating_space_placeholder') !!}" name="heating_m3">
							</span>
            <span id="isolation">
								<h3>{!! translate('kabola.configurator.isolation') !!}</h3>
								<select name="isolation">
									<option value="150">{!! translate('kabola.configurator.bad_factor_150') !!}</option>
									<option value="120">{!! translate('kabola.configurator.good_factor_120') !!}</option>
								</select>
							</span>
            <span id="applicationarea">
								<h3>{!! translate('kabola.configurator.application_area') !!}</h3>
								<select name="application_area">
									<option value="a">{!! translate('kabola.configurator.maritime') !!}</option>
									<option value="b">{!! translate('kabola.configurator.automotive') !!}</option>
									<option value="c">{!! translate('kabola.configurator.buildings') !!}</option>
									<option value="d">{!! translate('kabola.configurator.water_heating') !!}</option>
									<option value="e">{!! translate('kabola.configurator.other_options') !!}</option>
								</select>
							</span>
            <input type="submit" value="{!! translate('kabola.configurator.show_my_advice') !!} »" id="submit">
			{!! csrf_field() !!}
		</form>
    </div>
    <div class="configurator-sidebar wow animated5 fadeInUp">
        <img src="/themes/kabola/assets/img/teamphoto-tijdelijk.png">
        <h3>{!! translate('kabola.configurator.contact_our_advisors') !!}</h3>
        <span>{!! translate('kabola.configurator.phone_number') !!}</span>
        <a href="mailto:{!! translate('kabola.configurator.email_address') !!}">{!! translate('kabola.configurator.email_address') !!}</a>
    </div>
</div>