<div id="app" class="app-wrapper">
    <notifications></notifications>
    <side-bar @toggle="toggleSidebar"></side-bar>
    <div class="main">
        <app-header @toggle="toggleSidebar"></app-header>
        <div class="content">
            <transition
                    name="app-route-transition"
                    enter-active-class="animated slideInLeft"
                    leave-active-class="animated slideOutLeft"
            >
                <router-view class="router-outlet"></router-view>
            </transition>
        </div>
    </div>
    <transition
            name="app-overlay-transition"
            enter-active-class="animated fadeIn"
            leave-active-class="animated fadeOut"
            appear-acitive-class="animated fadeIn"
            :appear="true"
    >
        <div @click="hideOverlay" v-if="overlay" class="app-overlay"></div>
    </transition>
</div>