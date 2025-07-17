<?php
// Calculator shortcodes

// Associate teacher 
function associate_teacher_shortcode() {
    ob_start(); ?>

      <div class="bg-white text-rock-gray-900 shadow-lg p-8 mb-[2em]" data-aos="zoom-in">
        
        <div id="form-container" class="pt-6">
          <div id="tutor-calc" class="mt-6 py-4 form-section">
            <div class="grid md:grid-cols-3 gap-8">
              <!-- Title -->
              <div>
                <h3>Associate Calculator</h3>
                <div class="flex flex-col gap-4 mt-6 pb-2">
                  <button id="teacher-tab" class="py-2 px-4 border-2 text-rock-gray-900 border-b-4 focus:outline-none active-tab-button" data-target="teacher-form">
                    Teacher
                  </button>
                  <button id="school-tab" class="py-2 px-4 text-gray-600 border-b-4 focus:outline-none" data-target="school-form">
                    School
                  </button>
                </div>

              </div>
              <!-- Inputs -->
              <div>
                <h5 id="associate-heading-form" class="text-xl font-semibold mb-4 text-rock-gray-800">Teacher Calculator</h5>
                <div class="mb-4 school-calculator hidden">
                  <label class="block mb-2 text-gray-700 font-medium">
                    Number of Teaching Studios: <span id="noOfTeachersValue" class="text-rock-blue-700 font-bold">3</span>
                  </label>
                  <input id="noOfTeachers" type="range" min="3" max="50" step="1" value="3" class="w-full h-2 rounded-lg appearance-none cursor-pointer range-gradient">
                </div>

                <div class="mb-4 school-calculator hidden">
                  <label class="block mb-2 text-gray-700 font-medium">
                    Number of Sessions Per Day Per Teaching Studios: <span id="noOfSessionsValue" class="text-rock-blue-700 font-bold">3</span>
                  </label>
                  <input id="noOfSessions" type="range" min="3" max="10" step="1" value="3" class="w-full h-2 rounded-lg appearance-none cursor-pointer range-gradient">
                </div>

                <div class="mb-4">
                  <label class="block mb-2 text-gray-700 font-medium">
                    Number of Students per Session: <span id="studentsPerClassValue" class="text-rock-blue-700 font-bold">2</span>
                  </label>
                  <input id="studentsPerClass" type="range" min="1" max="5" value="2" class="w-full h-2 rounded-lg appearance-none cursor-pointer range-gradient">
                </div>

                <div class="mb-4 school-calculator hidden">
                  <label class="block mb-2 text-gray-700 font-medium">
                    Number of Working days Per Week: <span id="noOfWDValue" class="text-rock-blue-700 font-bold">3</span>
                  </label>
                  <input id="noOfWD" type="range" min="1" max="7" step="1" value="3" class="w-full h-2 rounded-lg appearance-none cursor-pointer range-gradient">
                </div>

                <div class="mb-4 teacher-calculator">
                  <label class="block mb-2 text-gray-700 font-medium">
                    Number of Sessions per Week: <span id="lessonsPerEveningValue" class="text-rock-blue-700 font-bold">15</span>
                  </label>
                  <input id="lessonsPerEvening" type="range" min="7" max="50" value="15"
                  class="w-full h-2 rounded-lg appearance-none cursor-pointer range-gradient" />
                </div>

                <div class="mb-4">
                  <label class="block mb-2 text-gray-700 font-medium">
                   Number of Weeks per Year: <span id="weeksPerYearValue" class="text-rock-blue-700 font-bold">45</span>
                  </label>
                  <input id="weeksPerYear" type="range" min="30" max="45" value="45" class="w-full h-2 rounded-lg appearance-none cursor-pointer range-gradient">
                </div>

                <div class="mb-4">
                  <label class="block mb-2 text-gray-700 font-medium">
                    Price per Student (£): <span id="costPerLessonValue" class="text-rock-blue-700 font-bold">30</span>
                  </label>
                  <input id="costPerLesson" type="range" min="15" max="50" step="0.5" value="30" class="w-full h-2 rounded-lg appearance-none cursor-pointer range-gradient">
                  <p class="text-sm text-gray-500 mt-1">Musician's Union rate per hour= £42.50</p>
                </div>
              </div>

              <!-- Results -->
              <div class="rounded-lg">
                <h5 class="text-xl font-semibold mb-4 text-rock-gray-900">Estimated Income</h5>
                <div class="space-y-4 text-lg">
                  <p class="school-calculator hidden"><strong>Gross per Day:</strong> <span class="block text-2xl font-bold text-rock-green-700">£<span id="grossPerDay">0.00</span></span></p>
                  <p><strong>Gross per Week:</strong> <span class="block text-2xl font-bold text-rock-green-700">£<span id="grossPerWeek">0.00</span></span></p>
                  <p><strong>Gross per Month:</strong> <span class="block text-2xl font-bold text-rock-green-700">£<span id="grossPerMonth">0.00</span></span></p>
                  <p><strong>Gross per Year:</strong> <span class="block text-4xl font-bold text-rock-green-700">£<span id="grossPerYear">0.00</span></span></p>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
    

    <script>
      document.addEventListener('DOMContentLoaded', () => {
        bindInputListeners();
      });

      // Get both buttons
      const teacherTab = document.getElementById('teacher-tab');
      const schoolTab = document.getElementById('school-tab');
      const heading = document.getElementById('associate-heading-form');
      let activeTab = 'teacher';


      // Add click event listeners
      teacherTab.addEventListener('click', () => {
        teacherTab.classList.add('active-tab-button');
        schoolTab.classList.remove('active-tab-button');
        heading.textContent = 'Teacher Calculator';
        activeTab = 'teacher';

        // add hidden elements with calls school-calculator 
        document.querySelectorAll('.school-calculator')?.forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.teacher-calculator')?.forEach(el => el.classList.remove('hidden'));
        bindInputListeners();
        calculateIncomeTeacher();


      });

      schoolTab.addEventListener('click', () => {
        schoolTab.classList.add('active-tab-button');
        teacherTab.classList.remove('active-tab-button');
        heading.textContent = 'School Calculator';
        activeTab = 'school';
        //show elements with calls school-calculator
        document.querySelectorAll('.school-calculator')?.forEach(el => el.classList.remove('hidden'));
        document.querySelectorAll('.teacher-calculator')?.forEach(el => el.classList.add('hidden'));
        bindInputListeners();
        calculateIncomeSchool();
      });

      function formatCurrency(value) {
	        return value.toLocaleString('en-UK', {
	            minimumFractionDigits: 2,
	            maximumFractionDigits: 2
	        });
	    }
      function calculateIncomeTeacher() {
        const studentsEl = document.getElementById('studentsPerClass');
        const lessonsEl = document.getElementById('lessonsPerEvening');
        const costEl = document.getElementById('costPerLesson');
        const WeekPerYearEl = document.getElementById('weeksPerYear');


        const students = parseFloat(studentsEl.value) || 0;
        const lessons = parseFloat(lessonsEl.value) || 0;
        const cost = parseFloat(costEl.value) || 0;
        const weeksPerYear = parseFloat(WeekPerYearEl.value) || 0;

        const grossEvening = students * lessons * cost;
        const grossMonth = grossEvening * 4.33;
        const grossYear = grossEvening * weeksPerYear;

        document.getElementById('studentsPerClassValue').textContent = students;
        document.getElementById('lessonsPerEveningValue').textContent = lessons;
        document.getElementById('weeksPerYearValue').textContent = weeksPerYear;
        document.getElementById('costPerLessonValue').textContent = cost.toFixed(2);

        document.getElementById('grossPerWeek').textContent = formatCurrency(grossEvening);
        document.getElementById('grossPerMonth').textContent = formatCurrency(grossMonth);
        document.getElementById('grossPerYear').textContent = formatCurrency(grossYear);
      }

      function calculateIncomeSchool() {
        const noOfTeachersEl = document.getElementById('noOfTeachers');
        const noOfSessionsEl = document.getElementById('noOfSessions');
        const noOfWDEl = document.getElementById('noOfWD');
        const lessonsPerEveningEl = document.getElementById('lessonsPerEvening');
        const studentsPerClassEl = document.getElementById('studentsPerClass');
        const weeksPerYearEl = document.getElementById('weeksPerYear');
        const costPerLessonEl = document.getElementById('costPerLesson');

        const noOfTeachers = parseFloat(noOfTeachersEl.value) || 0;
        const noOfSessions = parseFloat(noOfSessionsEl.value) || 0;
        const noOfWD = parseFloat(noOfWDEl.value) || 0;
        const lessonsPerEvening = parseFloat(lessonsPerEveningEl.value) || 0;
        const studentsPerClass = parseFloat(studentsPerClassEl.value) || 0;
        const weeksPerYear = parseFloat(weeksPerYearEl.value) || 0;
        const costPerLesson = parseFloat(costPerLessonEl.value) || 0;

        // Calculate gross income
        const grossPerDay =  noOfTeachers * (noOfSessions * studentsPerClass * costPerLesson);
        const grossPerWeek = grossPerDay * noOfWD;
        const grossPerMonth = grossPerWeek * 4.33; // Average weeks per month
        const grossPerYear = grossPerWeek * weeksPerYear;

        // Update the display
        document.getElementById('noOfTeachersValue').textContent = noOfTeachers;
        document.getElementById('noOfSessionsValue').textContent = noOfSessions;
        document.getElementById('noOfWDValue').textContent = noOfWD;
        
        document.getElementById('lessonsPerEveningValue').textContent = lessonsPerEvening;
        document.getElementById('studentsPerClassValue').textContent = studentsPerClass;
        document.getElementById('weeksPerYearValue').textContent = weeksPerYear;
        document.getElementById('costPerLessonValue').textContent = costPerLesson.toFixed(2);
        document.getElementById('grossPerDay').textContent = formatCurrency(grossPerDay);
        document.getElementById('grossPerWeek').textContent = formatCurrency(grossPerWeek);
        document.getElementById('grossPerMonth').textContent = formatCurrency(grossPerMonth);
        document.getElementById('grossPerYear').textContent = formatCurrency(grossPerYear);
      }

      function bindInputListeners() {
        const inputs = document.querySelectorAll('#tutor-calc input');

        inputs.forEach(input => {
          // Remove existing listeners by cloning (optional improvement to avoid duplicates)
          const cloned = input.cloneNode(true);
          input.replaceWith(cloned);

          // Bind correct calculator
          if (activeTab === 'school') {
            cloned.addEventListener('input', calculateIncomeSchool);
          } else {
            cloned.addEventListener('input', calculateIncomeTeacher);
          }
        });
      }
      calculateIncomeTeacher();
      
      
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