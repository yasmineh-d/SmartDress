// resources/js/components/admin/adminDashboard.js
import Alpine from 'alpinejs';

export default function adminDashboard() {
    return {
        // state
        tab: 'dashboard',
        isEditing: false,
        showModal: false,
        modalType: 'activity',
        activities: [],
        users: [],
        currentActivity: {
            id: null,
            name: '',
            action: 'Génération de tenue',
            initial: ''
        },
        currentUser: {
            id: null,
            name: '',
            email: '',
            role: 'User',
            status: 'Actif'
        },
        rowToDelete: null,

        // methods
        openAddModal() {
            this.isEditing = false;
            if (this.tab === 'dashboard') {
                this.modalType = 'activity';
                this.currentActivity = {
                    id: Date.now(),
                    name: '',
                    action: 'Génération de tenue',
                    initial: ''
                };
            } else {
                this.modalType = 'user';
                this.currentUser = {
                    id: Date.now(),
                    name: '',
                    email: '',
                    role: 'User',
                    status: 'Actif'
                };
            }
            this.showModal = true;
        },
        openEditModal(item) {
            this.isEditing = true;
            if (this.tab === 'dashboard') {
                this.modalType = 'activity';
                this.currentActivity = { ...item };
            } else {
                this.modalType = 'user';
                this.currentUser = { ...item };
            }
            this.showModal = true;
        },
        save() {
            if (this.modalType === 'activity') {
                if (!this.currentActivity.name) return;
                this.currentActivity.initial = this.currentActivity.name
                    .split(' ')
                    .map(n => n[0])
                    .join('')
                    .toUpperCase()
                    .substring(0, 2);
                if (this.isEditing) {
                    const idx = this.activities.findIndex(a => a.id === this.currentActivity.id);
                    this.activities[idx] = { ...this.currentActivity, time: 'Just now' };
                } else {
                    this.activities.unshift({ ...this.currentActivity, time: 'Just now' });
                }
            } else {
                if (!this.currentUser.name || !this.currentUser.email) return;
                if (this.isEditing) {
                    const idx = this.users.findIndex(u => u.id === this.currentUser.id);
                    this.users[idx] = { ...this.currentUser };
                } else {
                    this.users.unshift({ ...this.currentUser });
                }
            }
            this.showModal = false;
        },
        deleteRow(item) {
            this.rowToDelete = item;
        },
        confirmDelete() {
            if (!this.rowToDelete) return;
            if (this.tab === 'dashboard') {
                this.activities = this.activities.filter(a => a.id !== this.rowToDelete.id);
            } else {
                this.users = this.users.filter(u => u.id !== this.rowToDelete.id);
            }
            this.rowToDelete = null;
        },
        // computed helpers
        get modalTitle() {
            return this.isEditing
                ? `Édition ${this.modalType === 'activity' ? "d'activité" : "d'utilisateur"}`
                : `Création ${this.modalType === 'activity' ? "d'activité" : "d'utilisateur"}`;
        }
    };
}

// Register component (if you want this file to auto‑register)
if (typeof Alpine !== 'undefined') {
    Alpine.data('adminDashboard', adminDashboard);
}
