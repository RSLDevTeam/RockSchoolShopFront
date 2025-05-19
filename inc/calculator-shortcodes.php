<?php
// Calculator shortcodes

// Associate teacher 
function associate_teacher_shortcode() {
    ob_start(); ?>
    
      <div id="tutor-calc" class="bg-white text-rock-gray-900 shadow-lg p-8 mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 mb-[2em]" data-aos="zoom-in">
      	<h3>Associate Teacher</h3>
        <!-- Left: Inputs -->
        <div>
          <h5 class="text-2xl font-semibold mb-6">Income Inputs</h5>

          <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">
              Number per class: <span id="studentsPerClassValue" class="font-bold text-[1.2em]">2</span>
            </label>
            <input type="range" id="studentsPerClass" value="2" min="1" max="10" step="1"
              class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
          </div>

          <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">
              Lessons per evening: <span id="lessonsPerEveningValue" class="font-bold text-[1.2em]">3</span>
            </label>
            <input type="range" id="lessonsPerEvening" value="3" min="1" max="5" step="1"
              class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
          </div>

          <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">
              Cost per lesson (£): <span id="costPerLessonValue" class="font-bold text-[1.2em]">42.50</span>
            </label>
            <input type="range" id="costPerLesson" value="42.5" min="15" max="50" step="0.5"
              class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
            <span class="small-text">Musician's Union rate = £42.50</span>
          </div>
        </div>

        <!-- Right: Results -->
        <div>
          <h5 class="text-2xl font-semibold mb-6">Estimated Income</h5>
          <div class="space-y-4 text-lg">
              <p>
                <strong>Gross per evening:</strong>
                <span class="block font-bold text-[2em] result-metric">£<span id="grossEvening">0.00</span></span>
              </p>
              <p>
                <strong>Gross per month<br>(3 evenings/wk × 4 wks):</strong>
                <span class="block font-bold text-[2.2em] result-metric">£<span id="grossMonth">0.00</span></span>
              </p>
              <p>
                <strong>Gross per year<br>(3 evenings/wk × 45 wks):</strong>
                <span class="block font-bold text-[2.8em] result-metric">£<span id="grossYear">0.00</span></span>
              </p>
            </div>
        </div>
      </div>

    <script>
      function formatCurrency(value) {
        return value.toLocaleString('en-UK', {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        });
      }

      function calculateIncome() {
        const studentsEl = document.getElementById('studentsPerClass');
        const lessonsEl = document.getElementById('lessonsPerEvening');
        const costEl = document.getElementById('costPerLesson');

        const students = parseFloat(studentsEl.value) || 0;
        const lessons = parseFloat(lessonsEl.value) || 0;
        const cost = parseFloat(costEl.value) || 0;

        const grossEvening = students * lessons * cost;
        const grossMonth = grossEvening * 3 * 4;
        const grossYear = grossEvening * 3 * 45;

        document.getElementById('studentsPerClassValue').textContent = students;
        document.getElementById('lessonsPerEveningValue').textContent = lessons;
        document.getElementById('costPerLessonValue').textContent = cost.toFixed(2);

        document.getElementById('grossEvening').textContent = formatCurrency(grossEvening);
        document.getElementById('grossMonth').textContent = formatCurrency(grossMonth);
        document.getElementById('grossYear').textContent = formatCurrency(grossYear);
      }

      document.querySelectorAll('#tutor-calc input').forEach(input => {
        input.addEventListener('input', calculateIncome);
      });

      calculateIncome();
    </script>

    <?php
    return ob_get_clean();
}
add_shortcode('associate_teacher', 'associate_teacher_shortcode');

// Associate school
function associate_school_shortcode() {
    ob_start(); ?>

    <div id="school-calc" class="bg-white text-rock-gray-900 shadow-lg p-8 mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 mb-[2em]" data-aos="zoom-in">

    	<h3>Associate School / Franchise Model Per Tutor - Per Session</h3>
        <!-- Left: Inputs -->
        <div>
            <h5 class="text-2xl font-semibold mb-6">School Income</h5>

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">
                    Number of students per class: <span id="schoolStudentsValue" class="font-bold text-[1.2em]">3</span>
                </label>
                <input type="range" id="schoolStudents" value="3" min="1" max="10" step="1"
                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">
                    Lessons per evening: <span id="schoolLessonsValue" class="font-bold text-[1.2em]">8</span>
                </label>
                <input type="range" id="schoolLessons" value="8" min="1" max="10" step="1"
                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">
                    Cost per lesson (£): <span id="schoolCostValue" class="font-bold text-[1.2em]">25.00</span>
                </label>
                <input type="range" id="schoolCost" value="25" min="10" max="50" step="0.5"
                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">
                    School commission (%): <span id="schoolCommissionValue" class="font-bold text-[1.2em]">65</span>
                </label>
                <input type="range" id="schoolCommission" value="65" min="0" max="100" step="1"
                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">
                    Sessions per week: <span id="schoolSessionsValue" class="font-bold text-[1.2em]">6</span>
                </label>
                <input type="range" id="schoolSessions" value="6" min="1" max="14" step="1"
                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
            </div>
        </div>

        <!-- Right: Results -->
        <div>
            <h5 class="text-2xl font-semibold mb-6">Estimated Revenue</h5>
            <div class="space-y-4 text-lg">
                <p>
                    <strong>Gross revenue to school:</strong>
                    <span class="block font-bold text-[2em]">£<span id="schoolGross">0.00</span></span>
                </p>
                <p>
                    <strong>Net revenue for school:</strong>
                    <span class="block font-bold text-[2em]">£<span id="schoolNetSchool">0.00</span></span>
                </p>
                <p>
                    <strong>Net revenue for teacher:</strong>
                    <span class="block font-bold text-[2em]">£<span id="schoolNetTeacher">0.00</span></span>
                </p>
                <p>
                    <strong>Net revenue for teacher per week:</strong>
                    <span class="block font-bold text-[2.8em]">£<span id="schoolTeacherWeekly">0.00</span></span>
                </p>
                <p>
				  <strong>Net revenue for school per week:</strong>
				  <span class="block font-bold text-[2.8em]">£<span id="schoolWeeklySchool">0.00</span></span>
				</p>
            </div>
        </div>
    </div>

	<div id="school-multi" class="bg-white text-rock-gray-900 shadow-lg p-8 mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 mb-[2em]" data-aos="zoom-in">

	    <h3 class="text-xl font-semibold mb-4">Associate School (Multiple Studios / Tutors)</h3>
	    <div>
	        <h5 class="text-2xl font-semibold mb-6">Additional</h5>

	        <div class="mb-6">
	            <label class="block text-gray-700 font-medium mb-2">
	                Number of Teaching Studios / Teachers: <span id="schoolStudiosValue" class="font-bold text-[1.2em]">5</span>
	            </label>
	            <input type="range" id="schoolStudios" value="5" min="1" max="10" step="1"
	                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
	        </div>

	        <div class="mb-6">
	            <label class="block text-gray-700 font-medium mb-2">
	                Number of Evenings / Days: <span id="schoolDaysValue" class="font-bold text-[1.2em]">6</span>
	            </label>
	            <input type="range" id="schoolDays" value="6" min="1" max="7" step="1"
	                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
	        </div>
	    </div>

	    <div class="">
	        <h5 class="text-2xl font-semibold mb-6">Revenue</h5>
	        <div class="space-y-4 text-lg">
	            <p>
	                <strong>Gross Income – 4 Week Month:</strong>
	                <span class="block font-bold text-[2em]">£<span id="schoolGrossMonth">0.00</span></span>
	            </p>
	            <p>
	                <strong>Gross Income – 32 Week Academic Year:</strong>
	                <span class="block font-bold text-[2em]">£<span id="schoolGrossYear">0.00</span></span>
	            </p>
	            <p>
	                <strong>Net Income (after teaching costs) – 32 Week Acc. Year:</strong>
	                <span class="block font-bold text-[2.8em]">£<span id="schoolNetYear">0.00</span></span>
	            </p>
	        </div>
	    </div>
	</div>

	<script>
	    function formatCurrency(value) {
	        return value.toLocaleString('en-UK', {
	            minimumFractionDigits: 2,
	            maximumFractionDigits: 2
	        });
	    }

	    function calculateSchoolRevenue() {
	        // Main calculator values
	        const students = parseFloat(document.getElementById('schoolStudents').value) || 0;
	        const lessons = parseFloat(document.getElementById('schoolLessons').value) || 0;
	        const cost = parseFloat(document.getElementById('schoolCost').value) || 0;
	        const commission = parseFloat(document.getElementById('schoolCommission').value) || 0;
	        const sessions = parseFloat(document.getElementById('schoolSessions').value) || 0;

	        // Calculated base values
	        const gross = students * lessons * cost;
	        const netSchool = gross * (commission / 100);
	        const netTeacher = gross - netSchool;
	        const weeklySchool = netSchool * sessions;
	        const weeklyTeacher = netTeacher * sessions;

	        // Update display for base calculator
	        document.getElementById('schoolStudentsValue').textContent = students;
	        document.getElementById('schoolLessonsValue').textContent = lessons;
	        document.getElementById('schoolCostValue').textContent = cost.toFixed(2);
	        document.getElementById('schoolCommissionValue').textContent = commission;
	        document.getElementById('schoolSessionsValue').textContent = sessions;

	        document.getElementById('schoolGross').textContent = formatCurrency(gross);
	        document.getElementById('schoolNetSchool').textContent = formatCurrency(netSchool);
	        document.getElementById('schoolNetTeacher').textContent = formatCurrency(netTeacher);
	        document.getElementById('schoolWeeklySchool').textContent = formatCurrency(weeklySchool);
	        document.getElementById('schoolTeacherWeekly').textContent = formatCurrency(weeklyTeacher);

	        // Multi-studio input values
	        const studios = parseFloat(document.getElementById('schoolStudios').value) || 0;
	        const days = parseFloat(document.getElementById('schoolDays').value) || 0;

	        // Extended revenue calculations
	        const grossMonth = gross * studios * days * 4;
	        const grossYear = gross * studios * days * (32 / 6);
	        const netYear = netTeacher * studios * days * (32 / 6);

	        // Update display for multi-studio section
	        document.getElementById('schoolStudiosValue').textContent = studios;
	        document.getElementById('schoolDaysValue').textContent = days;

	        document.getElementById('schoolGrossMonth').textContent = formatCurrency(grossMonth);
	        document.getElementById('schoolGrossYear').textContent = formatCurrency(grossYear);
	        document.getElementById('schoolNetYear').textContent = formatCurrency(netYear);
	    }

	    // Bind to all sliders in both sections
	    document.querySelectorAll('#school-calc input, #school-multi input').forEach(input => {
	        input.addEventListener('input', calculateSchoolRevenue);
	    });

	    // Initial run
	    calculateSchoolRevenue();
	</script>

    <?php
    return ob_get_clean();
}
add_shortcode('associate_school', 'associate_school_shortcode');