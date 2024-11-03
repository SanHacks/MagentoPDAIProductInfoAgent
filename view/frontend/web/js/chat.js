define(['jquery'], function($) {

    const chatBox = document.getElementById('chat-box');
    const chatUrl = 'https://app.m2demo.test/rest/V1/productinfoagent/message';

    /**
     * @param sender
     * @param message
     */
    function appendMessage(sender, message) {
        const messageElement = document.createElement('div');
        messageElement.classList.add('message', sender);
        chatBox.appendChild(messageElement);

        if (sender === 'assistant') {
            streamMessage(message, messageElement);
        } else {
            messageElement.textContent = message;
        }

        chatBox.scrollTop = chatBox.scrollHeight;
    }

    /**
     * @param text
     * @param element
     */
    function streamMessage(text, element) {
        let index = 0;
        const interval = setInterval(() => {
            if (index < text.length) {
                element.textContent += text[index];
                index++;
                chatBox.scrollTop = chatBox.scrollHeight;
            } else {
                clearInterval(interval);
            }
        }, 60);
    }

    /**
     * @returns {Promise<void>}
     */
    async function sendMessage() {
        // const productDescription = <?= $productName ?>
        const userInput = document.getElementById('user-input').value;
        if (!userInput.trim()) return;

        appendMessage('user', userInput);
        document.getElementById('user-input').value = '';

        const loadingMessage = document.createElement('div');
        loadingMessage.classList.add('message', 'assistant');
        loadingMessage.innerHTML = '<span class="loading">...</span>';
        chatBox.appendChild(loadingMessage);

        const formKey = document.querySelector('input[name="form_key"]').value;

        try {
            const response = await fetch(chatUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'referer': chatUrl
                },
                body: JSON.stringify({ message: productDescription + userInput }),
            });

            const data = await response.json();
            chatBox.removeChild(loadingMessage);

            const responseMessage = data || "I couldn't find an answer to that question.";
            appendMessage('assistant', responseMessage);

        } catch (error) {
            console.error('Error:', error);
            chatBox.removeChild(loadingMessage);
        }
    }

    /**
     * @param question
     */
    function sendSuggestedQuestion(question) {
        // appendMessage('user', question);
        document.getElementById('user-input').value = question;
        sendMessage();
    }
});
