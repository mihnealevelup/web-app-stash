<?php
// formular de contact protejat prin csrf, captcha aritmetica si honeypot
/** @var string $csrf_token */
/** @var string $captcha */
$old = $old ?? [];
?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <h1 class="h3 mb-3">Contact</h1>
            <p class="text-muted mb-4">
                Casting calls, distribution enquiries, press requests: write to us and the studio will get back to you.
            </p>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="/contact" class="row g-3" novalidate>
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

                <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required
                           value="<?= htmlspecialchars($old['name'] ?? '') ?>">
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required
                           value="<?= htmlspecialchars($old['email'] ?? '') ?>">
                </div>

                <div class="col-12">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" class="form-control" id="subject" name="subject"
                           value="<?= htmlspecialchars($old['subject'] ?? '') ?>">
                </div>

                <div class="col-12">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="6" required><?= htmlspecialchars($old['message'] ?? '') ?></textarea>
                </div>

                <div class="col-md-6">
                    <label for="captcha" class="form-label"><?= htmlspecialchars($captcha) ?></label>
                    <input type="text" class="form-control" id="captcha" name="captcha" required autocomplete="off">
                    <div class="form-text">A quick check that you are not a robot.</div>
                </div>

                <div class="honeypot" aria-hidden="true">
                    <label for="website">Leave this field empty</label>
                    <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary px-4">Send message</button>
                </div>
            </form>
        </div>
    </div>
</div>
