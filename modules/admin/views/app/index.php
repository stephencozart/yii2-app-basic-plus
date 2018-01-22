<div id="app" class="app-wrapper">
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

</div>