const API_URL = import.meta.env.VITE_API_URL;

window.appData = function () {
  return {
    currentPage: 'vetements',
    vetements: [],
    tenues: [],
    favoris: [],
    loading: true,
    error: null,

    async fetchData() {
      this.loading = true;
      this.error = null;

      try {
        if (this.currentPage === 'vetements') {
          const res = await fetch(`${API_URL}/vetements`);
          const json = await res.json();
          this.vetements = json.success ? json.data : [];
        } else if (this.currentPage === 'tenues') {
          const res = await fetch(`${API_URL}/tenues`);
          const json = await res.json();
          this.tenues = json.success ? json.data : [];
        } else if (this.currentPage === 'favoris') {
          const res = await fetch(`${API_URL}/favoris`);
          const json = await res.json();
          this.favoris = json.success ? json.data : [];
        }
      } catch (e) {
        this.error = "Impossible de se connecter à l'API";
      } finally {
        this.loading = false;
      }
    },

    changePage(page) {
      this.currentPage = page;
      this.fetchData();
    },
  };
};
