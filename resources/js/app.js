import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

window.Echo.channel("chat").listen(".message.event", (e) => {
    console.log("New message: ", e.message);
});
