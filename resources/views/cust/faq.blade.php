@extends('base.base')

@section('content')
<style>
  body {
    font-family: Arial, sans-serif;
    margin: 0; padding: 20px; background: #fff;
    color: #000;
  }
  .breadcrumb {
    font-size: 14px;
    margin-bottom: 20px;
    color: #555;
  }
  .breadcrumb span {
    font-weight: 600;
  }
  h1 {
    margin-bottom: 25px;
  }
  .faq-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
  }
  .faq-sidebar {
    flex: 1 1 180px;
    max-width: 180px;
    border-right: 1px solid #ddd;
  }
  .faq-sidebar button {
    width: 100%;
    text-align: left;
    padding: 12px 15px;
    border: none;
    border-bottom: 1px solid #ddd;
    background: #f9f9f9;
    cursor: pointer;
    font-weight: 600;
    font-size: 14px;
  }
  .faq-sidebar button.active,
  .faq-sidebar button:hover {
    background-color: #CFD1D4;
    color: #000;
  }

  .faq-content {
    flex: 3 1 600px;
    max-width: 800px;
  }

  .faq-item {
    border: 1px solid #ddd;
    border-radius: 6px;
    margin-bottom: 12px;
    box-shadow: 0 2px 8px rgb(0 0 0 / 0.05);
  }

  .faq-question {
    padding: 15px 20px;
    background-color: #fff;
    cursor: pointer;
    font-weight: 600;
    position: relative;
    user-select: none;
  }
  .faq-question::before {
    position: absolute;
    left: 20px;
    font-weight: 700;
    font-size: 18px;
    transition: transform 0.3s ease;
  }
  .faq-question.active::before {

    /* You can use "-" or a minus sign for toggle */
  }

  .faq-answer {
    padding: 15px 20px;
    display: none;
    background: #fff;
    font-weight: 200;
    font-size: 14px;
    line-height: 1.5;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .faq-container {
      flex-direction: column;
    }
    .faq-sidebar {
      max-width: 100%;
      border-right: none;
      border-bottom: 1px solid #ddd;
      margin-bottom: 20px;
    }
  }
</style>

<div class="breadcrumb">
  Home / <span>FAQ (EN)</span>
</div>

<h1>FAQ</h1>

<div class="faq-container">
  <nav class="faq-sidebar" aria-label="FAQ Categories">
    <button class="faq-tab active" data-category="registration">Registration</button>
    <button class="faq-tab" data-category="orders">Orders</button>
    <button class="faq-tab" data-category="products">Products</button>
    <button class="faq-tab" data-category="payment">Payment</button>
    <button class="faq-tab" data-category="shipping">Shipping</button>
    <button class="faq-tab" data-category="returns">Returns</button>
  </nav>

  <section class="faq-content" role="region" aria-live="polite">
    <!-- Registration -->
    <div class="faq-category" data-category="registration" style="display: block;">
      <div class="faq-item">
        <div class="faq-question" tabindex="0" aria-expanded="false">Do I need to register as a member before I can shop at Kickin?</div>
        <div class="faq-answer">Yes, you need to register and become a member to be able to make purchases at Kickin.</div>
      </div>
      <div class="faq-item">
        <div class="faq-question" tabindex="0" aria-expanded="false">How do I register as a Kickin member?</div>
        <div class="faq-answer">You can register through the registration page on our website by filling out the registration form.</div>
      </div>
      <div class="faq-item">
        <div class="faq-question" tabindex="0" aria-expanded="false">How do I update my account?</div>
        <div class="faq-answer">You can update your account details through the profile page after logging in.</div>
      </div>
      <div class="faq-item">
        <div class="faq-question" tabindex="0" aria-expanded="false">What if I forget my password?</div>
        <div class="faq-answer">You can use the "Forgot Password" feature to reset your password via your registered email.</div>
      </div>
      <div class="faq-item">
        <div class="faq-question" tabindex="0" aria-expanded="false">How do I update my shipping address?</div>
        <div class="faq-answer">You can update your shipping address on the address settings page in your account.</div>
      </div>
    </div>

    <!-- Orders -->
    <div class="faq-category" data-category="orders" style="display: none;">
      <div class="faq-item">
        <div class="faq-question" tabindex="0" aria-expanded="false">How do I place an order?</div>
        <div class="faq-answer">You can select products and add them to your cart, then proceed to checkout.</div>
      </div>
      <div class="faq-item">
        <div class="faq-question" tabindex="0" aria-expanded="false">Can I cancel an order?</div>
        <div class="faq-answer">You can cancel an order as long as it has not been processed by us.</div>
      </div>
    </div>

    <!-- Products -->
    <div class="faq-category" data-category="products" style="display: none;">
      <div class="faq-item">
        <div class="faq-question" tabindex="0" aria-expanded="false">Are the products sold genuine?</div>
        <div class="faq-answer">All products at Kickin are genuine and official.</div>
      </div>
      <div class="faq-item">
        <div class="faq-question" tabindex="0" aria-expanded="false">Is there a product warranty?</div>
        <div class="faq-answer">Product warranty is available according to the manufacturer’s terms.</div>
      </div>
    </div>

    <!-- Payment -->
    <div class="faq-category" data-category="payment" style="display: none;">
      <div class="faq-item">
        <div class="faq-question" tabindex="0" aria-expanded="false">What payment methods are available?</div>
        <div class="faq-answer">We accept bank transfers, credit cards, and digital payments.</div>
      </div>
    </div>

    <!-- Shipping -->
    <div class="faq-category" data-category="shipping" style="display: none;">
      <div class="faq-item">
        <div class="faq-question" tabindex="0" aria-expanded="false">How long does shipping take?</div>
        <div class="faq-answer">Shipping usually takes 3-5 business days depending on location.</div>
      </div>
    </div>

    <!-- Returns -->
    <div class="faq-category" data-category="returns" style="display: none;">
      <div class="faq-item">
        <div class="faq-question" tabindex="0" aria-expanded="false">What is the return procedure?</div>
        <div class="faq-answer">You can submit a return request through your account page within 7 days after receiving the product.</div>
      </div>
    </div>
  </section>
</div>

<script>
  // Toggle FAQ answer display
  document.querySelectorAll('.faq-question').forEach(question => {
    question.addEventListener('click', () => {
      const isActive = question.classList.contains('active');
      // Close all answers in this category
      const faqCategory = question.closest('.faq-category');
      faqCategory.querySelectorAll('.faq-question').forEach(q => {
        q.classList.remove('active');
        q.setAttribute('aria-expanded', 'false');
        q.nextElementSibling.style.display = 'none';
      });

      if (!isActive) {
        question.classList.add('active');
        question.setAttribute('aria-expanded', 'true');
        question.nextElementSibling.style.display = 'block';
      }
    });

    // Keyboard accessibility
    question.addEventListener('keydown', e => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        question.click();
      }
    });
  });

  // Sidebar tab switching
  const tabs = document.querySelectorAll('.faq-tab');
  const categories = document.querySelectorAll('.faq-category');

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      // Remove active class from all tabs
      tabs.forEach(t => t.classList.remove('active'));
      // Hide all categories
      categories.forEach(c => {
        c.style.display = 'none';
      });

      // Show selected category
      const category = tab.getAttribute('data-category');
      const activeCategory = document.querySelector(`.faq-category[data-category="${category}"]`);
      if (activeCategory) activeCategory.style.display = 'block';

      // Add active class to clicked tab
      tab.classList.add('active');

      // Collapse all open answers when switching categories
      activeCategory.querySelectorAll('.faq-question').forEach(q => {
        q.classList.remove('active');
        q.setAttribute('aria-expanded', 'false');
        q.nextElementSibling.style.display = 'none';
      });
    });
  });
</script>

@endsection
