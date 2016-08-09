<H1>Verzoek via Kabola.nl</H1>

<p><strong>Gewenst type:</strong> {{ implode(', ', $selected_products) }}</p>
<p><strong>Gewenste water inhoud:</strong> {{ implode(' - ', $water_capacity) }} liter</p>
<p><strong>Gewenst capaciteit:</strong> {{ implode(' - ', $capacity) }} kW</p>
<p><strong>Gewenste efficienty:</strong> {{ implode(', ', $efficiency) }} %</p>

<h2>Contactgegevens</h2>
<p><strong>E-mail:</strong>{{ $mail }}</p>
<p><strong>Telefoon:</strong>{{ $phone }}</p>