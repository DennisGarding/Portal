<script>
import MessageContainer from '@/components/Base/MessageContainer.vue'

export default {
  name: 'App',
  components: {
    MessageContainer,
  },

  computed: {
    isLoading() {
      return this.$mainStore.isLoading()
    },
  },

  methods: {
    oncloseMessage(message) {
      this.$mainStore.removeMessage(message.id)
    },
  },
}
</script>

<template>
  <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">

    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="/">Portal</a>

    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-lg order-1 order-lg-0 me-4 me-lg-0" href="#!">
      <i class="bi bi-list"></i>
    </button>

    <!-- Navbar Search-->
      <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">
          <input
            class="form-control"
            type="text"
            placeholder="Search for..."
            aria-label="Search for..."
            aria-describedby="btnNavbarSearch"
          />
          <button class="btn btn-primary" id="btnNavbarSearch" type="button">
            <i class="bi bi-search"></i>
          </button>
        </div>
      </form>
    <message-container
      @close-message="oncloseMessage"
      :messages="this.$mainStore.messages"
      :sticky-messages="this.$mainStore.stickyMessages"
    />

  </nav>
  <div id="layoutSidenav">
    <!-- Navbar left side -->
    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
          <div class="nav">
            <router-link :to="{ name: 'Home' }" class="nav-link">
              <div class="sb-nav-link-icon">
                <i class="bi bi-house-door"></i>
              </div>
              Home
            </router-link>

            <router-link :to="{ name: 'Categories' }" class="nav-link">
              <div class="sb-nav-link-icon">
                <i class="bi bi-diagram-3-fill"></i>
              </div>
              Categories
            </router-link>

            <router-link :to="{ name: 'Links' }" class="nav-link">
              <div class="sb-nav-link-icon">
                <i class="bi bi-link-45deg"></i>
              </div>
              Links
            </router-link>
          </div>
        </div>
        <div class="sb-sidenav-footer">
          <div class="mb-3">
            <div>Logged in as:</div>
            <div class="small">
              <!--                            {{ userMail }}-->
            </div>
            <div class="mt-2">
              <a href="/logout">Logout</a>
            </div>
          </div>
        </div>
      </nav>
    </div>

    <!-- Main content -->
    <div id="layoutSidenav_content">
      <main>
        <div class="content-container container">
          <RouterView />
        </div>
      </main>

      <!-- Footer -->
      <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
          <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">
              Portal
              <i class="bi bi-arrow-through-heart-fill"></i>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>

  <div v-if="isLoading" class="loading d-flex justify-content-center">
    <div class="spinner spinner-border text-light align-content-center" role="status">
      <span class="sr-only visually-hidden">Loading...</span>
    </div>
  </div>
</template>

<style>
@import './../node_modules/bootstrap-icons/font/bootstrap-icons.css';

@import './assets/bootstrap.min.css';

.content-container {
  position: absolute;
  left: 0;
}

.loading {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.6);

  .spinner {
    position: absolute;
    top: 50%;
    width: 3rem;
    height: 3rem;
  }
}

.fixed-top,
.sb-nav-fixed #layoutSidenav #layoutSidenav_nav,
.sb-nav-fixed .sb-topnav {
  position: fixed;
  top: 0;
  right: 0;
  left: 0;
  z-index: 1030;
}

#layoutSidenav {
  display: flex;
}

#layoutSidenav #layoutSidenav_nav {
  flex-basis: 225px;
  flex-shrink: 0;
  transition: transform 0.15s ease-in-out;
  z-index: 1038;
  transform: translateX(-225px);
}

#layoutSidenav #layoutSidenav_content {
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  min-width: 0;
  flex-grow: 1;
  min-height: calc(100vh - 56px);
  margin-left: -225px;
}

.sb-sidenav-toggled #layoutSidenav #layoutSidenav_nav {
  transform: translateX(0);
}

.sb-sidenav-toggled #layoutSidenav #layoutSidenav_content:before {
  content: '';
  display: block;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: #000;
  z-index: 1037;
  opacity: 0.5;
  transition: opacity 0.3s ease-in-out;
}

@media (min-width: 992px) {
  #layoutSidenav #layoutSidenav_nav {
    transform: translateX(0);
  }

  #layoutSidenav #layoutSidenav_content {
    margin-left: 0;
    transition: margin 0.15s ease-in-out;
  }

  .sb-sidenav-toggled #layoutSidenav #layoutSidenav_nav {
    transform: translateX(-225px);
  }

  .sb-sidenav-toggled #layoutSidenav #layoutSidenav_content {
    margin-left: -225px;
  }

  .sb-sidenav-toggled #layoutSidenav #layoutSidenav_content:before {
    display: none;
  }
}

.sb-nav-fixed .sb-topnav {
  z-index: 1039;
}

.sb-nav-fixed #layoutSidenav #layoutSidenav_nav {
  width: 225px;
  height: 100vh;
  z-index: 1038;
}

.sb-nav-fixed #layoutSidenav #layoutSidenav_nav .sb-sidenav {
  padding-top: 56px;
}

.sb-nav-fixed #layoutSidenav #layoutSidenav_nav .sb-sidenav .sb-sidenav-menu {
  overflow-y: auto;
}

.sb-nav-fixed #layoutSidenav #layoutSidenav_content {
  padding-left: 225px;
  top: 56px;
}

.sb-sidenav {
  display: flex;
  flex-direction: column;
  height: 100%;
  flex-wrap: nowrap;
}

.sb-sidenav .sb-sidenav-menu {
  flex-grow: 1;
}

.sb-sidenav .sb-sidenav-menu .nav {
  flex-direction: column;
  flex-wrap: nowrap;
}

.sb-sidenav .sb-sidenav-menu .nav .sb-sidenav-menu-heading {
  padding: 1.75rem 1rem 0.75rem;
  font-size: 0.75rem;
  font-weight: bold;
  text-transform: uppercase;
}

.sb-sidenav .sb-sidenav-menu .nav .nav-link {
  display: flex;
  align-items: center;
  padding-top: 0.75rem;
  padding-bottom: 0.75rem;
  position: relative;
}

.sb-sidenav .sb-sidenav-menu .nav .nav-link .sb-nav-link-icon {
  font-size: 0.9rem;
  margin-right: 0.75rem;
}

.sb-sidenav .sb-sidenav-menu .nav .nav-link .sb-sidenav-collapse-arrow {
  display: inline-block;
  margin-left: auto;
  transition: transform 0.15s ease;
}

.sb-sidenav .sb-sidenav-menu .nav .nav-link.collapsed .sb-sidenav-collapse-arrow {
  transform: rotate(-90deg);
}

.sb-sidenav .sb-sidenav-menu .nav .sb-sidenav-menu-nested {
  margin-left: 1.5rem;
  flex-direction: column;
}

.sb-sidenav .sb-sidenav-footer {
  padding: 0.75rem;
  flex-shrink: 0;
}

.sb-sidenav-dark {
  background-color: #212529;
  color: rgba(255, 255, 255, 0.5);
}

.sb-sidenav-dark .sb-sidenav-menu .sb-sidenav-menu-heading {
  color: rgba(255, 255, 255, 0.25);
}

.sb-sidenav-dark .sb-sidenav-menu .nav-link {
  color: rgba(255, 255, 255, 0.5);
}

.sb-sidenav-dark .sb-sidenav-menu .nav-link .sb-nav-link-icon {
  color: rgba(255, 255, 255, 0.25);
}

.sb-sidenav-dark .sb-sidenav-menu .nav-link .sb-sidenav-collapse-arrow {
  color: rgba(255, 255, 255, 0.25);
}

.sb-sidenav-dark .sb-sidenav-menu .nav-link:hover {
  color: #fff;
}

.sb-sidenav-dark .sb-sidenav-menu .nav-link.active {
  color: #fff;
}

.sb-sidenav-dark .sb-sidenav-menu .nav-link.active .sb-nav-link-icon {
  color: #fff;
}

.sb-sidenav-dark .sb-sidenav-footer {
  background-color: #343a40;
}

.sb-sidenav-light {
  background-color: #f8f9fa;
  color: #212529;
}

.sb-sidenav-light .sb-sidenav-menu .sb-sidenav-menu-heading {
  color: #adb5bd;
}

.sb-sidenav-light .sb-sidenav-menu .nav-link {
  color: #212529;
}

.sb-sidenav-light .sb-sidenav-menu .nav-link .sb-nav-link-icon {
  color: #adb5bd;
}

.sb-sidenav-light .sb-sidenav-menu .nav-link .sb-sidenav-collapse-arrow {
  color: #adb5bd;
}

.sb-sidenav-light .sb-sidenav-menu .nav-link:hover {
  color: #0d6efd;
}

.sb-sidenav-light .sb-sidenav-menu .nav-link.active {
  color: #0d6efd;
}

.sb-sidenav-light .sb-sidenav-menu .nav-link.active .sb-nav-link-icon {
  color: #0d6efd;
}

.sb-sidenav-light .sb-sidenav-footer {
  background-color: #e9ecef;
}
</style>
