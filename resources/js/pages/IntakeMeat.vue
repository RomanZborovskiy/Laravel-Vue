<template>
  <div class="container">
    <div class="item-form">
      <h2>Додати новий елемент</h2>
      
      <form @submit.prevent="submitForm">
        <div class="form-group">
          <label for="name">Назва:</label>
          <input 
            type="text" 
            id="name" 
            v-model="formData.name" 
            required
            class="form-control"
            :class="{'is-invalid': errors.name}"
          >
          <div v-if="errors.name" class="invalid-feedback">
            {{ errors.name }}
          </div>
        </div>
        <button type="submit" class="btn btn-primary" :disabled="loading">
          <span v-if="loading">Збереження...</span>
          <span v-else>Зберегти</span>
        </button>
      </form>

      <div v-if="successMessage" class="alert alert-success mt-3">
        {{ successMessage }}
      </div>

      <div v-if="errorMessage" class="alert alert-danger mt-3">
        {{ errorMessage }}
      </div>
    </div>

    <div class="mt-5">
      <h3>Список елементів</h3>
      <div class="table-responsive">
        <table class="table table-striped mt-4">
          <thead class="thead-dark">
            <tr>
              <th>ID</th>
              <th>Назва робочої зміни</th>
              <th>Ім'я користувача</th>
              <th>Дата створення</th>
              <th>Кнопка</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in items" :key="item.id">
              <td>{{ item.id }}</td>
              <td>{{ item.name }}</td>
              <td>{{ item.user_name }}</td>
              <td>{{ formatDate(item.created_at) }}</td>
              <th><button @click="goTo(item.id)">Переглянути</button></th>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import api from '../api/api';

export default {
  data() {
    return {
      items: [],
      formData: {
        name: '',
        user_id: '',
      },
      errors: {},
      successMessage: '',
      errorMessage: '',
      loading: false
    };
  },
  async created() {
    await this.loadItems();
  },
  methods: {
    async loadItems() {
      try {
        const response = await api.get('/intake_meat');
        this.items = response.data.data || response.data; 
      } catch (error) {
        console.error('Помилка завантаження:', error);
        this.errorMessage = 'Не вдалося завантажити дані';
      }
    },
    
    validateForm() {
      this.errors = {};
      let isValid = true;

      if (!this.formData.name.trim()) {
        this.errors.name = 'Будь ласка, введіть назву';
        isValid = false;
      }


      return isValid;
    },
    
    async submitForm() {
      if (!this.validateForm()) return;

      this.loading = true;
      this.successMessage = '';
      this.errorMessage = '';

      try {
        const response = await api.post('/intake_meat', this.formData);
        
        this.successMessage = 'Дані успішно збережено!';
        this.resetForm();
        await this.loadItems(); 
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.errors = error.response.data.errors || {};
          this.errorMessage = 'Будь ласка, виправте помилки у формі';
        } else {
          this.errorMessage = 'Помилка при збереженні: ' + 
            (error.response?.data?.message || error.message);
        }
      } finally {
        this.loading = false;
      }
    },
    
    resetForm() {
      this.formData = {
        name: '',
        user_id: '',
      };
      this.errors = {};
    },
    
    formatDate(dateString) {
      if (!dateString) return '';
      const date = new Date(dateString);
      return date.toLocaleString();
    },

   goTo(id) {
      this.$router.push({ path: `/intake_meat/${id}` });
    },
  }
};
</script>

<style scoped>
.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

.item-form {
  background: #f8f9fa;
  padding: 25px;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.form-group {
  margin-bottom: 20px;
}

label {
  display: block;
  margin-bottom: 8px;
  font-weight: 600;
  color: #495057;
}

.form-control {
  width: 100%;
  padding: 10px 15px;
  border: 1px solid #ced4da;
  border-radius: 4px;
  font-size: 16px;
  transition: border-color 0.15s;
}

.form-control:focus {
  border-color: #80bdff;
  outline: 0;
  box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
}

.is-invalid {
  border-color: #dc3545;
}

.invalid-feedback {
  color: #dc3545;
  font-size: 14px;
  margin-top: 5px;
}

.btn {
  padding: 10px 20px;
  font-size: 16px;
  border-radius: 4px;
  transition: all 0.3s;
}

.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
}

.btn-primary:hover {
  background-color: #0069d9;
  border-color: #0062cc;
}

.btn-primary:disabled {
  background-color: #6c757d;
  border-color: #6c757d;
  cursor: not-allowed;
}

.alert {
  padding: 15px;
  border-radius: 4px;
  margin-top: 20px;
}

.alert-success {
  background-color: #d4edda;
  color: #155724;
  border: 1px solid #c3e6cb;
}

.alert-danger {
  background-color: #f8d7da;
  color: #721c24;
  border: 1px solid #f5c6cb;
}

.table {
  margin-top: 30px;
  width: 100%;
}

.thead-dark {
  background-color: #343a40;
  color: white;
}

.table-striped tbody tr:nth-of-type(odd) {
  background-color: rgba(0, 0, 0, 0.05);
}

.table-responsive {
  overflow-x: auto;
}
</style>