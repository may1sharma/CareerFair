<div id='fg_membersite'>
    <form id='register' action='' method='post' accept-charset='UTF-8'>
    <fieldset >
    <h2> 
      <legend>Add new Job Posting</legend>
    </h2>

    <input type='hidden' name='submitted' id='submitted' value='1'/>

    <div class='short_explanation'>*required fields </div>

    <div><span class='error'><?php echo $handler->GetErrorMessage(); ?></span></div>
    <div class='container'>
        <label for='position' >Position*: </label><br/>
        <input type='text' name='position' id='position' value='<?php echo $handler->SafeDisplay('position') ?>' maxlength="50" /><br/>
        <span id='register_position_errorloc' class='error'></span>
    </div>
    <div class='container'>
        <label for='jtype' >Job type*</label><br/>
        <select name='jtype' id='jtype'>
            <option value=0>Full Time</option>
            <option value=1>Part Time</option>
            <option value=2>Internship</option>
        </select><br/>
        <span id='register_allowIntl_errorloc' class='error'></span>
    </div>
    <div class='container'>
        <label for='degree_check_list[]' >Required Degree Level*: 
        </label><br/>
        <?PHP for ($i = 1; $i < count($Degree_Level_List); $i++) {
            echo '<input type="checkbox" name="degree_check_list[]" value="'.$i.'">
                <label>'.$Degree_Level_List[$i].'</label><br/>';
        } ?>
        <!-- <input type="checkbox" name="degree_check_list[]" value="1"><label>Freshmen</label><br/>
        <input type="checkbox" name="degree_check_list[]" value="2"><label>Sophomores</label><br/>
        <input type="checkbox" name="degree_check_list[]" value="3"><label>Juniors</label><br/>
        <input type="checkbox" name="degree_check_list[]" value="4"><label>Seniors</label><br/>
        <input type="checkbox" name="degree_check_list[]" value="5"><label>Masters</label><br/>
        <input type="checkbox" name="degree_check_list[]" value="6"><label>PhD</label><br/> -->
        <span id='register_degree_errorloc' class='error'></span>
    </div>
    <div class='container'>
        <label for='dept_check_list[]' >Open for Departments*: </label><br/>
        <?PHP for ($i = 1; $i < count($Department_List); $i++) {
            echo '<input type="checkbox" name="dept_check_list[]" value="'.$i.'">
                <label>'.$Department_List[$i].'</label><br/>';
        } ?>
        <!-- <input type="checkbox" name="dept_check_list[]" value="1"><label>Computer Science</label><br/>
        <input type="checkbox" name="dept_check_list[]" value="2"><label>Computer Engineering</label><br/>
        <input type="checkbox" name="dept_check_list[]" value="3"><label>Electronics</label><br/>
        <input type="checkbox" name="dept_check_list[]" value="4"><label>Mechanical</label><br/>
        <input type="checkbox" name="dept_check_list[]" value="5"><label>Civil</label><br/>
        <input type="checkbox" name="dept_check_list[]" value="6"><label>Chemical</label><br/>
        <input type="checkbox" name="dept_check_list[]" value="7"><label>Performing Arts</label><br/>
        <input type="checkbox" name="dept_check_list[]" value="8"><label>Mathematics</label><br/>
        <input type="checkbox" name="dept_check_list[]" value="9"><label>Psychology</label><br/> -->
        <span id='register_degree_errorloc' class='error'></span>
    </div>
    <div class='container'>
        <label for='intl' >Can International Students apply?*</label><br/>
        <select name='intl' id='intl'>
            <option value=0>No</option>
            <option value=1>Yes</option>
        </select><br/>
        <span id='register_allowIntl_errorloc' class='error'></span>
    </div>

    <div class='container'>
        <input type='submit' name='Submit' value='Submit' />
    </div>

    </fieldset>
    </form>     
</div>    