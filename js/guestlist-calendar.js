(function () {
  const pageSize = 6;

  function initialiseCalendar(calendar) {
    const tabs = Array.from(calendar.querySelectorAll('[data-calendar-tab]'));
    const panels = Array.from(calendar.querySelectorAll('[data-calendar-panel]'));
    const discipline = calendar.querySelector('[data-calendar-discipline]');
    const day = calendar.querySelector('[data-calendar-day]');

    function filterPanel(panel) {
      const cards = Array.from(panel.querySelectorAll('[data-calendar-card]'));
      const disciplineValue = String(discipline?.value || '');
      const dayValue = String(day?.value || '');
      const page = Number(panel.dataset.page || 1);
      const matches = cards.filter((card) => (
        (!disciplineValue || card.dataset.discipline === disciplineValue)
        && (!dayValue || card.dataset.day === dayValue)
      ));

      cards.forEach((card) => {
        const matchingIndex = matches.indexOf(card);
        card.hidden = matchingIndex === -1 || matchingIndex >= page * pageSize;
      });

      const empty = panel.querySelector('[data-calendar-filter-empty]');
      const actions = panel.querySelector('[data-calendar-actions]');
      if (empty) {
        empty.hidden = matches.length > 0 || cards.length === 0;
      }
      if (actions) {
        actions.hidden = matches.length <= page * pageSize;
      }
    }

    function activateTab(name) {
      panels.forEach((panel) => {
        const active = panel.dataset.calendarPanel === name;
        panel.hidden = !active;
        if (active) {
          filterPanel(panel);
        }
      });
      tabs.forEach((tab) => {
        const active = tab.dataset.calendarTab === name;
        tab.classList.toggle('is-active', active);
        tab.setAttribute('aria-selected', active ? 'true' : 'false');
      });
    }

    tabs.forEach((tab) => tab.addEventListener('click', () => activateTab(tab.dataset.calendarTab)));
    [discipline, day].forEach((select) => select?.addEventListener('change', () => {
      panels.forEach((panel) => {
        panel.dataset.page = '1';
      });
      const activePanel = panels.find((panel) => !panel.hidden);
      if (activePanel) {
        filterPanel(activePanel);
      }
    }));
    panels.forEach((panel) => {
      panel.dataset.page = '1';
      panel.querySelector('[data-calendar-more]')?.addEventListener('click', () => {
        panel.dataset.page = String(Number(panel.dataset.page || 1) + 1);
        filterPanel(panel);
      });
    });

    activateTab(calendar.dataset.defaultTab || 'classes');
  }

  function boot() {
    document.querySelectorAll('[data-guestlist-calendar]').forEach(initialiseCalendar);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }
})();
