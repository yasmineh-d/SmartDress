const API_URL = import.meta.env.VITE_API_URL;

window.dashboardData = function () {
  return {
    vetements: [],
    loading: true,
    error: null,

    async fetchVetements() {
      try {
        const res = await fetch(`${API_URL}/vetements`);
        const json = await res.json();

        if (json.success) {
          this.vetements = json.data;
        } else {
          this.error = "Erreur lors du chargement";
        }
      } catch (e) {
        this.error = "Impossible de se connecter à l'API";
      } finally {
        this.loading = false;
      }
    },
  };
};
