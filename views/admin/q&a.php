<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Q&A Section</title>
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #181a20;
      color: #fff;
      margin: 0;
      padding: 0;
    }
    .container {
      display: flex;
      flex-direction: column;
      padding: 2rem;
    }
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
    }
    .header h1 {
      font-size: 2rem;
      font-weight: bold;
    }
    .ask-question {
      display: flex;
      flex-direction: column;
      gap: 1rem;
      margin-bottom: 2rem;
    }
    .input-field {
      display: flex;
      gap: 1rem;
      align-items: center;
    }
    .input-field label {
      font-size: 1.2rem;
      flex-basis: 150px;
    }
    .input-field input, .input-field select {
      flex-grow: 1;
      padding: 0.5rem;
      border: 1px solid #ccc;
      border-radius: 0.25rem;
      font-size: 1rem;
      background-color: #2d2d2d;
      color: #fff;
    }
    .input-field button {
      padding: 0.5rem 1rem;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 0.25rem;
      cursor: pointer;
      font-size: 1rem;
    }
    .question-list {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }
    .question {
      background-color: #2d2d2d;
      border-radius: 0.25rem;
      padding: 1rem;
      cursor: pointer;
    }
    .question-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 0.5rem;
    }
    .question-header h3 {
      font-size: 1.2rem;
      font-weight: bold;
    }
    .question-header span {
      font-size: 0.8rem;
      color: #ccc;
    }
    .question-body {
      display: none;
      margin-top: 1rem;
    }
    .question-body.show {
      display: block;
    }
    .reply-section {
      background-color: #3d3d3d;
      border-radius: 0.25rem;
      padding: 1rem;
      margin-top: 1rem;
    }
    .reply-section textarea {
      width: 100%;
      height: 100px;
      padding: 0.5rem;
      border: 1px solid #ccc;
      border-radius: 0.25rem;
      font-size: 1rem;
      background-color: #2d2d2d;
      color: #fff;
      resize: vertical;
    }
    .reply-section button {
      padding: 0.5rem 1rem;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 0.25rem;
      cursor: pointer;
      font-size: 1rem;
      margin-top: 0.5rem;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Q&A Section</h1>
      <div class="search-filter">
        <!-- Search and filter options -->
      </div>
    </div>
    <div class="ask-question">
      <div class="input-field">
        <label for="question-title">Question Title:</label>
        <input type="text" id="question-title" placeholder="Enter your question">
      </div>
      <div class="input-field">
        <label for="question-category">Category:</label>
        <select id="question-category">
          <option value="">Select a category</option>
          <option value="technical-support">Technical Support</option>
          <option value="account-issues">Account Issues</option>
          <option value="service-queries">Service Queries</option>
          <option value="payment-issues">Payment Issues</option>
        </select>
      </div>
      <div class="input-field">
        <button id="submit-question">Submit Question</button>
      </div>
    </div>
    <div class="question-list">
      <div class="question">
        <div class="question-header">
          <h3>How do I update my garage's business hours?</h3>
          <span>Technical Support | 2023-04-12 10:30 AM | Customer</span>
        </div>
        <div class="question-body show">
          <p>I need to update my garage's business hours, but I'm not sure how to do it. Can someone please help?</p>
          <div class="reply-section">
            <textarea placeholder="Enter your reply..."></textarea>
            <button>Submit Answer</button>
          </div>
        </div>
      </div>
      <div class="question">
        <div class="question-header">
          <h3>I'm having trouble with my online payment</h3>
          <span>Payment Issues | 2023-04-10 3:45 PM | Customer</span>
        </div>
        <div class="question-body">
          <p>I'm trying to make a payment online but the system keeps giving me an error. What should I do?</p>
          <div class="reply-section">
            <textarea placeholder="Enter your reply..."></textarea>
            <button>Submit Answer</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    const questions = document.querySelectorAll('.question');

    questions.forEach(question => {
      question.addEventListener('click', () => {
        question.classList.toggle('show');
      });
    });
  </script>
</body>
</html>