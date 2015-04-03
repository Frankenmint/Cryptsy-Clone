<p align="right" style="float:right;" class="iframe3 cboxElement"><b></b><select id="setit" style="color: #000000" size="1" name="test">
			<option value="">Select Action</option>
			<option value="/<?php echo strtolower($coin1);?>/makedeposit.php">Deposit <?php echo $coin1;?></option>
			<option value="/<?php echo strtolower($coin1);?>/makewithdrawal.php">Withdraw <?php echo $coin1;?></option>
			<option value="/users/deposits.php?coin=<?php echo $coin1;?>">View <?php echo $coin1;?> Deposit</option>
			<option value="/users/withdrawals.php?coin=<?php echo $coin1;?>">View <?php echo $coin1;?> Withdrawals</option>
			</select><input type="button" value="Go"onclick="window.open(setit.options[setit.selectedIndex].value)"></p>