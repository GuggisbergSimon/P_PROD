<p>
	<label for="resDate">Date de la réservation :</label>
	<input type="date" name="resDate" id="resDate" />
</p>

<p>
	<label for="resTable">Numéro de table :</label>
	<input type="number" name="resTable" min="1" max="18" value="1">
</p>

<p>
	<label for="resHour">Heure de la réservation : (première periode)</label>
	<input type="time" id="resHour" name="resHour"
	min="11:20" max="12:00" required>
	
	<label for="resHour2">Heure de la réservation : (deuxième periode)</label>
	<input type="time" id="resHour2" name="resHour2"
	min="12:10" max="13:50" required>
</p>	

<p>

  <label for="resMeal">Choisir un Plat :</label>
  <select id="resMeal" name="resMeal">
	<option value="resMeal1">Menu du jour 1</option>
	<option value="resMeal2">Menu du jour 2</option>
	<option value="resMeal3">Menu pâtes</option>
	<option value="resMeal4">Menu burger</option>
	<option value="resMeal5">Menu Végetarien</option>
  </select>
  <input type="submit" value="Envoyer">
	
</p>	

	</label><br><br>