<fieldset style="width: 450px; padding: 15px; border: 1px solid black;">
    <legend style="font-weight: bold;">Person Details</legend>
    <form name="myform" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        
        <div style="margin-bottom: 8px;">
            <label style="display:inline-block; text-align:right; width:120px;">Surname:</label>
            <input type="text" name="surname" size="25" value="<?php echo isset($_POST['surname']) ? htmlspecialchars($_POST['surname']) : ''; ?>" />
        </div>

        <div style="margin-bottom: 8px;">
            <label style="display:inline-block; text-align:right; width:120px;">Email address:</label>
            <input type="text" name="email" size="25" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" />
        </div>

        <div style="margin-bottom: 8px;">
            <label style="display:inline-block; text-align:right; width:120px;">Password:</label>
            <input type="password" name="passwd" size="25" />
        </div>

        <div style="margin-bottom: 8px;">
            <label style="display:inline-block; text-align:right; width:120px; vertical-align:top;">Street Address:</label>
            <textarea name="address" rows="3" cols="22"><?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?></textarea>
        </div>

        <div style="margin-bottom: 8px;">
            <label style="display:inline-block; text-align:right; width:120px;">State:</label>
            <select name="state">
                <?php
                $states = [
                    "-1" => "[choose your state]",
                    "1" => "Australian Capital Territory",
                    "2" => "Queensland",
                    "3" => "Victoria",
                    "4" => "New South Wales",
                    "5" => "Tasmania",
                    "6" => "South Australia",
                    "7" => "Western Australia",
                    "8" => "Northern Territory"
                ];
                $selected = isset($_POST['state']) ? $_POST['state'] : '-1';
                foreach ($states as $val => $name) {
                    $sel = ($selected == $val) ? 'selected' : '';
                    echo "<option value=\"$val\" $sel>$name</option>";
                }
                ?>
            </select>
        </div>

        <input type="hidden" name="country" value="Australia" />

        <div style="margin-bottom: 8px;">
            <label style="display:inline-block; text-align:right; width:120px;">Gender:</label>
            <?php $sex = isset($_POST['sex']) ? $_POST['sex'] : ''; ?>
            <input type="radio" name="sex" value="male" <?php echo ($sex == 'male') ? 'checked' : ''; ?> /> Male
            <input type="radio" name="sex" value="female" <?php echo ($sex == 'female') ? 'checked' : ''; ?> /> Female
        </div>

        <div style="margin-bottom: 8px;">
            <label style="display:inline-block; text-align:right; width:120px;">Vegetarian?</label>
            <input type="checkbox" name="vegetarian" value="1" <?php echo isset($_POST['vegetarian']) ? 'checked' : ''; ?> />
        </div>

        <div style="text-align: center; margin-top: 12px;">
            <input type="submit" value="Submit" name="submit" />
            <input type="reset" value="Reset" name="reset" />
        </div>
    </form>
</fieldset>