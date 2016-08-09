@extends('app')
@section('pageid')"front-page"@endsection
@section('content')
    <div class="frontimage">
        <div class="content wow animated zoomIn">
            <h1>{!! translate('kabola.home_title') !!}</h1>
            <h2>{!! translate('kabola.home_subtitle') !!}</h2>
            <p>{!! translate('kabola.home_promo_text') !!}</p>
            <a href="" class="c2a">{!! translate('kabola.home_wacht_our_promo') !!}</a>
            <a href="">{!! translate('kabola.general.read_more')  !!}</a>
        </div>
    </div>
    <div class="upcomingevents">
        <div class="section wow animated fadeIn">
            <ul>
                <li id="thisisupcoming">
                    <span>Upcoming[EVENTS]</span>
                </li>
                <li>
                    <a href="">
                        <span class="place">Antwerp</span>
                        <span class="date">28-06-'16</span>
                        <span class="description">Visit us @MGB Stand #156</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="place">Antwerp</span>
                        <span class="date">28-06-'16</span>
                        <span class="description">Visit us @MGB Stand #156</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="place">Antwerp</span>
                        <span class="date">28-06-'16</span>
                        <span class="description">Visit us @MGB Stand #156</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="place">Antwerp</span>
                        <span class="date">28-06-'16</span>
                        <span class="description">Visit us @MGB Stand #156</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="place">Antwerp</span>
                        <span class="date">28-06-'16</span>
                        <span class="description">Visit us @MGB Stand #156</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="place">Antwerp</span>
                        <span class="date">28-06-'16</span>
                        <span class="description">Visit us @MGB Stand #156</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="section">
        <div class="orbit productslider" role="region" data-orbit>
            <ul class="orbit-container">
                <button class="orbit-previous">&#9664;&#xFE0E;</button>
                <button class="orbit-next">&#9654;&#xFE0E;</button>
                <li class="is-active orbit-slide product-slide">
                    <h1>Sale</h1>
                    <h3>The most energy efficient and economical</h3>
                    <div class="slidecontent">
                        <div class="image">
                            <img src="/themes/kabola/assets/img/ketel-HR-400.png">
                        </div>
                        <div class="text">
                            <ul>
                                <li>100% soot-free</li>
                                <li>Environmentally friendly</li>
                                <li>Earn back your investment in 3 years!</li>
                                <li>TUV certification</li>
                            </ul>
                            <span class="sale">10%</span>
                            <a href="#" class="c2a">Read more</a>
                        </div>
                    </div>
                </li>
                <li class="orbit-slide product-slide">
                    <h1>Kabola HR titel</h1>
                    <h3>The most energy efficient and economical</h3>
                    <div class="slidecontent">
                        <div class="image">
                            <img src="/themes/kabola/assets/img/ketel-HR-400.png">
                        </div>
                        <div class="text">
                            <ul>
                                <li>100% soot-free</li>
                                <li>Environmentally friendly</li>
                                <li>Earn back your investment in 3 years!</li>
                                <li>TUV certification</li>
                            </ul>
                            <a href="#" class="c2a">Read more</a>
                        </div>
                    </div>
                </li>
                <li class="orbit-slide product-slide">
                    <h1>Kabola B 25</h1>
                    <h3>The most energy efficient and economical</h3>
                    <div class="slidecontent">
                        <div class="image">
                            <img src="/themes/kabola/assets/img/ketel-B-25.png">
                        </div>
                        <div class="text">
                            <ul>
                                <li>Up to 30% less energy consumption</li>
                                <li>Up to 15% fuel savings</li>
                                <li>94% efficiency</li>
                                <li>100% soot-free</li>
                                <li>Environmentally friendly</li>
                                <li>Earn back your investment in 3 years!</li>
                                <li>TUV certification</li>
                            </ul>
                            <a href="#" class="c2a">Read more</a>
                        </div>
                    </div>
                </li>
                <li class="orbit-slide product-slide">
                    <h1>Kabola Compact 7</h1>
                    <h3>The most energy efficient and economical</h3>
                    <div class="slidecontent">
                        <div class="image">
                            <img src="/themes/kabola/assets/img/ketel-Compact-7.png">
                        </div>
                        <div class="text">
                            <ul>
                                <li>Up to 30% less energy consumption</li>
                                <li>Up to 15% fuel savings</li>
                                <li>94% efficiency</li>
                            </ul>
                            <a href="#" class="c2a">Read more</a>
                        </div>
                    </div>
                </li>
            </ul>
            <nav class="orbit-bullets">
                <button class="is-active" data-slide="0"></button>
                <button data-slide="1"></button>
                <button data-slide="2"></button>
            </nav>
        </div>
    </div>
    <div class="configurator wow animated fadeIn">
        <div class="section">
            <div class="configurator-content">
                <h1>Which boiler suits me?</h1>
                <p>The options with our boilers are endless. From fishing boats, horse trailer, barge to chalets. Enter
                    your preferences and we indicate you which type of boiler best suits your needs. Consult our
                    advisors for specific advice.</p>
                <h3>Application (multiple options possible)</h3>
                <form>
							<span id="application">
								<input type="checkbox" id="CentralHeating" value="CentralHeating">
								<label for="CentralHeating">Central Heating</label>
								<input type="checkbox" id="HotWater" value="HotWater">
								<label for="HotWater">Hot water</label>
								<input type="checkbox" id="HotAir" value="HotAir">
								<label for="HotAir">Hot air</label>
								<input type="checkbox" id="Airco" value="Airco">
								<label for="Airco">Airconditioning</label>
							</span>
							<span id="heatingspace">
								<h3>Heating space</h3>
								<select>
									<option>10-30 m3</option>
									<option>30-50 m3</option>
									<option>50-75 m3</option>
									<option>75+ m3</option>							
								</select>
							</span>
							<span id="isolation">
								<h3>Isolation</h3>
								<select>
									<option>Bad (factor 150)</option>
									<option>Good (factor 120)</option>
								</select>
							</span>
							<span id="applicationarea">
								<h3>Application area</h3>
								<select>
									<option>Maritiem</option>
									<option>Automotive</option>
									<option>Gebouwen</option>
									<option>Waterverwarming</option>
									<option>Overig</option>
								</select>
							</span>
                    <input type="submit" value="Show my advice »" id="submit">
                </form>
            </div>
            <div class="configurator-sidebar wow animated5 fadeInUp">
                <img src="/themes/kabola/assets/img/teamphoto-tijdelijk.png">
                <h3>Contact our advisors:</h3>
                <span>+31 347 320030</span>
                <a href="">info@kabola.nl</a>
            </div>
        </div>
    </div>
    <div class="findadealerbar">
        <div class="section">
            <h1>Find the closest Kabola dealer.</h1>
            <h2>Tell us where you are, and we'll show you the closest</h2>
            <a href="" class="wow animated5 fadeInRight">Find a dealer »</a>
        </div>
    </div>
    <div class="fullwidthslideshow orbit" role="region" data-orbit>
        <ul class="orbit-container">
            <button class="orbit-previous">&#9664;&#xFE0E;</button>
            <button class="orbit-next">&#9654;&#xFE0E;</button>
            <li class="is-active orbit-slide">
                <img src="/themes/kabola/assets/img/sfeerslider--moterjacht.jpg">
            </li>
            <li class="orbit-slide">
                <img src="/themes/kabola/assets/img/sfeerslider--chalet.jpg">
            </li>
            <li class="orbit-slide">
                <img src="/themes/kabola/assets/img/sfeerslider--paardentrailer.jpg">
            </li>
        </ul>
        <nav class="orbit-bullets">
            <button class="is-active" data-slide="0"></button>
            <button data-slide="1"></button>
            <button data-slide="2"></button>
        </nav>
    </div>
@endsection
