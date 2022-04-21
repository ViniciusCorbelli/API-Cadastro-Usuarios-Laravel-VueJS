<template>
  <div id="app">
    <nav>
      <div class="nav-wrapper nav">
        <a class="brand-logo center">
          <img
            src="https://www.planmkt.com.br/templates/default/images/logo_plan.png"
          />
        </a>
      </div>
    </nav>

    <div class="container">
      <ul>
        <div class="alerta alert-success">
          <li v-for="(sucesso, index) of sucessos" :key="index">
            {{ sucesso }}
          </li>
        </div>
      </ul>

      <ul>
        <div class="alerta alert-danger">
          <li v-for="(erro, index) of errors" :key="index">
            Erro no campo <b>{{ index }}</b
            >:
            <ol v-for="(msg, i) of erro" :key="i">
              {{
                msg
              }}
            </ol>
          </li>
        </div>
      </ul>

      <form @submit.prevent="create">
        <label>Nome *</label>
        <input type="text" class="form-control" v-model="user.name" />
        <label>E-mail *</label>
        <input type="text" class="form-control" v-model="user.email" />
        <label>Senha *</label>
        <input type="password" class="form-control" v-model="user.password" />
        <label>Telefone *</label>
        <input type="number" class="form-control" v-model="user.phone" />
        <label>Foto</label><br />
        <input type="file" class="form-control-file" @change="changeFile" />

        <button class="waves-effect waves-light btn-small">
          Salvar<i class="material-icons left">save</i>
        </button>
      </form>

      <hr />
      <h5>Usuários cadastrados</h5>
      <table>
        <thead>
          <tr>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Telefone</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="user of users" :key="user.id">
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.phone }}</td>
            <td>
              <button
                @click="editar(user)"
                class="waves-effect btn-small blue darken-1"
              >
                <i class="material-icons">create</i>
              </button>
              <button
                @click="remove(user)"
                class="waves-effect btn-small red darken-1"
              >
                <i class="material-icons">delete_sweep</i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import metodos from "../services/metodos";

export default {
  name: "app",
  data() {
    return {
      user: {
        id: "",
        name: "",
        email: "",
        password: "",
        phone: "",
        picture: "",
      },
      users: [],
      errors: [],
      sucessos: [],
    };
  },

  mounted() {
    this.get();
  },

  methods: {
    // Pega os dados do banco
    get() {
      metodos
        .get()
        .then((resposta) => {
          this.users = resposta.data.data.data;
        })
        .catch((e) => {
          this.errors = [];
          this.sucessos = [];
        });
    },

    create() {
      // Cria um usuario
      if (!this.user.id) {
        // Cria o formulario para enviar os dados
        const fd = new FormData();
        fd.append("id", this.user.id);
        fd.append("name", this.user.name);
        fd.append("email", this.user.email);
        fd.append("phone", this.user.phone);
        fd.append("password", this.user.password);
        // Verifica se existe imagem
        if (this.user.picture != "") {
          fd.append("picture", this.user.picture, this.user.picture.name);
        }

        metodos
          .create(fd)
          .then((resposta) => {
            this.user = {};
            this.sucessos = [resposta.data.data.mensagem];
            this.get();
            this.errors = {};
          })
          .catch((e) => {
            this.errors = e.response.data.data.erro;
            this.sucessos = [];
          });

        // Atualiza um usuario
      } else {
        metodos
          .update(this.user.id, this.user)
          .then((resposta) => {
            this.user = {};
            this.errors = {};
            this.sucessos = [resposta.data.data.mensagem];
            this.get();
          })
          .catch((e) => {
            this.errors = e.response.data.data.erro;
            this.sucessos = [];
          });
      }
    },

    // Coloca os dados do usuario no input para editar
    editar(user) {
      this.user = user;
      this.user.picture = "";
    },

    // Delata o usuario
    remove(user) {
      if (confirm("Deseja excluir o user?")) {
        metodos
          .delete(user.id)
          .then((resposta) => {
            this.get();
            this.errors = {};
            this.sucessos = [resposta.data.data.mensagem];
          })
          .catch((e) => {
            this.errors = e.response.data.data.erro;
            this.sucessos = [];
          });
      }
    },

    changeFile(e) {
      this.user.picture = e.target.files[0];
    },
  },
};
</script>

<style>
</style>