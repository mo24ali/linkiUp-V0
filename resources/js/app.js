import "./bootstrap";

// import Alpine from "alpinejs";

// window.Alpine = Alpine;

// Alpine.start();


// Note: chat-room listener is in messagerie/index.blade.php
// This file is for global Echo setup only


const userId = document.querySelector('meta[name="user-id"]')?.content;

if (userId && window.Echo) {
    console.log(`Subscribing to private channel for user ${userId}`);

    window.Echo.private(`chat.user.${userId}`)
        .listen('.message.sent', (e) => {
            addMessage(e.message.content);
        })
        .error((error) => {
            console.log('Error subscribing to private channel:', error);
        });
}

// Function to add the new message to the UI
function addMessage(text) {
    const container = document.getElementById('chat-messages');
    if (!container) return;

    const div = document.createElement('div');
    div.innerText = text;
    div.style.padding = '8px';
    div.style.margin = '5px';
    div.style.background = '#f1f1f1';

    container.appendChild(div);
}