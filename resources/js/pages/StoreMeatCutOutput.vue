<template>
  <div class="product-form">
    <h1>Форма для введення інформації про розбір перший раз</h1>
    <div v-if="products.length === 0" class="empty-state">
      <p>Немає доступних продуктів для відображення</p>
    </div>

    <div v-else>
      <div v-for="(product, index) in products" :key="index" class="product-item">
        <div class="inline-fields">
          <div class="form-group">
            <label>Назва</label>
            <input 
              type="text" 
              v-model="product.name" 
              class="form-control"
              readonly
            >
          </div>

          <div class="form-group" v-if="product.unit === 'pcs'">
            <label>Кількість (шт)</label>
            <input 
              type="number" 
              v-model.number="product.quantity" 
              @input="calculateWeight(index)"
              min="0"
              class="form-control"
            >
          </div>

          <div class="form-group" v-else>
            <label>Вага (кг)</label>
            <input 
              type="number" 
              v-model.number="product.weight" 
              step="0.01"
              min="0"
              class="form-control"
            >
          </div>

          <div class="form-group" v-if="product.unit === 'pcs'">
            <label>Вага (кг)</label>
            <input 
              type="number" 
              v-model.number="product.weight" 
              step="0.01"
              min="0"
              class="form-control"
              readonly
            >
            <div class="calculation-info">
              {{ product.quantity || 0 }} шт × {{ product.weight_per_piece }} кг = {{ product.weight }} кг
            </div>
          </div>
        </div>
      </div>
      <div class="summary">
        <h4>Загальна вага: {{ totalWeight.toFixed(2) }} кг</h4>
      </div>

      <button @click="submitForm" class="btn btn-primary" :disabled="totalWeight <= 0">
        Зберегти
      </button>
    </div>
  </div>
</template>

<script>
import api from '../api/api';

export default {
  data() {
    return {
      products: [],
      isLoading: true,
      meatIntakeItemId: this.$route.params.id,
      partId: this.$route.query.part_id,
      formData: {
        meat_intake_item_id: '',
        product_id: '',
        amount: '',
        total_weight_kg: '',
      }
    }
  },

  computed: {
    totalWeight() {
      return this.products.reduce((sum, product) => {
        return sum + (parseFloat(product.weight) || 0);
      }, 0);
    }
  },

  created() {
    this.fetchProducts();
  },

  methods: {
    async fetchProducts() {
      this.isLoading = true;
      try {
        const response = await api.get(`/meat_part/${this.partId}/products`);
        this.products = response.data.data.map(product => ({
          ...product,
          quantity: product.unit === 'pcs' ? 1 : null,
          weight: product.unit === 'pcs' ? parseFloat(product.weight_per_piece) : 0
          
        }));
      } catch (error) {
        console.error('Помилка при отриманні продуктів:', error);
      } finally {
        this.isLoading = false;
      }
    },

    calculateWeight(index) {
      const product = this.products[index];
      if (product.unit === 'pcs' && product.quantity > 0 && product.weight_per_piece) {
        product.weight = product.quantity * parseFloat(product.weight_per_piece);
      }
    },

    submitForm() {
      if (this.totalWeight <= 0) {
        alert('Будь ласка, вкажіть вагу для хоча б одного продукту');
        return;
      }
      const formData = this.products
        .filter(product => product.weight > 0)
        .map(product => ({
          meat_intake_item_id: this.meatIntakeItemId, 
          product_id: product.id, 
          amount: product.unit === 'pcs' ? product.quantity : null,
          total_weight_kg: product.weight,
        }));

      api.post('/meat_cut_output', { outputs: formData })
        .then(response => {
          alert('Дані успішно збережено!');
        })
        .catch(error => {
          console.error('Помилка при збереженні:', error);
          alert('Сталася помилка при збереженні даних');
        });
    }
  }
}
</script>

<style scoped>
.inline-fields {
  display: flex;
  gap: 15px;
  flex-wrap: wrap;
  align-items: flex-end;
}

.inline-fields .form-group {
  flex: 1 1 30%;
  min-width: 180px;
}

.product-form {
  margin: 20px 0;
  padding: 20px;
  background: #f9f9f9;
  border-radius: 8px;
}

.empty-state {
  text-align: center;
  padding: 40px;
  color: #666;
  font-size: 1.2em;
}

.product-item {
  border: 1px solid #ddd;
  padding: 15px;
  margin-bottom: 15px;
  border-radius: 5px;
  background: white;
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

.form-control {
  width: 100%;
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.form-control:read-only {
  background-color: #f5f5f5;
}

.calculation-info {
  margin-top: 5px;
  font-size: 0.9em;
  color: #28a745;
}

.summary {
  margin: 20px 0;
  padding: 15px;
  background: #e9ecef;
  border-radius: 5px;
  text-align: center;
}

.btn {
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 1em;
}

.btn-primary {
  background-color: #007bff;
  color: white;
}

.btn-primary:disabled {
  background-color: #cccccc;
  cursor: not-allowed;
}
</style>