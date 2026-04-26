<?php include("header.php"); ?>
<main>
    <section class="sip-section">
        <div class="container">
            <div class="sip-section-title">
                <span class="sip-badge">Official FAQ</span>
                <h2>Cryptocurrency facts and safety guidance</h2>
                <p>These answers cover the basics of crypto, account protection, and how to reduce common user-side risks.</p>
            </div>
            <div class="sip-faq-wrap">
                <div class="accordion" id="sipFaqAccordion">
                    <div class="accordion-item sip-faq-item">
                        <h2 class="accordion-header" id="sipHeadingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#sipCollapseOne" aria-expanded="true" aria-controls="sipCollapseOne">
                                What is cryptocurrency?
                            </button>
                        </h2>
                        <div id="sipCollapseOne" class="accordion-collapse collapse show" aria-labelledby="sipHeadingOne" data-bs-parent="#sipFaqAccordion">
                            <div class="accordion-body">Cryptocurrency is a digital asset that uses cryptography to secure transactions and control the creation of new units. Most coins and tokens are transferred on blockchain networks.</div>
                        </div>
                    </div>

                    <div class="accordion-item sip-faq-item">
                        <h2 class="accordion-header" id="sipHeadingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sipCollapseTwo" aria-expanded="false" aria-controls="sipCollapseTwo">
                                Why is crypto considered high risk?
                            </button>
                        </h2>
                        <div id="sipCollapseTwo" class="accordion-collapse collapse" aria-labelledby="sipHeadingTwo" data-bs-parent="#sipFaqAccordion">
                            <div class="accordion-body">Prices can move sharply, transactions can be irreversible, and users are responsible for keeping their wallets and recovery phrases secure. Regulatory treatment can also vary by jurisdiction.</div>
                        </div>
                    </div>

                    <div class="accordion-item sip-faq-item">
                        <h2 class="accordion-header" id="sipHeadingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sipCollapseThree" aria-expanded="false" aria-controls="sipCollapseThree">
                                What security measures help protect crypto accounts?
                            </button>
                        </h2>
                        <div id="sipCollapseThree" class="accordion-collapse collapse" aria-labelledby="sipHeadingThree" data-bs-parent="#sipFaqAccordion">
                            <div class="accordion-body">The most effective measures are two-step authentication, strong unique passwords, protected session handling, identity verification, withdrawal confirmation, and careful address checking before transfers.</div>
                        </div>
                    </div>

                    <div class="accordion-item sip-faq-item">
                        <h2 class="accordion-header" id="sipHeadingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sipCollapseFour" aria-expanded="false" aria-controls="sipCollapseFour">
                                What should I check before sending crypto?
                            </button>
                        </h2>
                        <div id="sipCollapseFour" class="accordion-collapse collapse" aria-labelledby="sipHeadingFour" data-bs-parent="#sipFaqAccordion">
                            <div class="accordion-body">Confirm the receiving address, the correct blockchain network, the asset type, and the amount. A mismatch in network or token can result in permanent loss of funds.</div>
                        </div>
                    </div>

                    <div class="accordion-item sip-faq-item">
                        <h2 class="accordion-header" id="sipHeadingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sipCollapseFive" aria-expanded="false" aria-controls="sipCollapseFive">
                                Are crypto transfers reversible?
                            </button>
                        </h2>
                        <div id="sipCollapseFive" class="accordion-collapse collapse" aria-labelledby="sipHeadingFive" data-bs-parent="#sipFaqAccordion">
                            <div class="accordion-body">In most cases, no. Once a transaction is confirmed on-chain, it cannot be reversed by the platform or the blockchain network. That is why verification before sending is critical.</div>
                        </div>
                    </div>

                    <div class="accordion-item sip-faq-item">
                        <h2 class="accordion-header" id="sipHeadingSix">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sipCollapseSix" aria-expanded="false" aria-controls="sipCollapseSix">
                                What are the top signs of a crypto scam?
                            </button>
                        </h2>
                        <div id="sipCollapseSix" class="accordion-collapse collapse" aria-labelledby="sipHeadingSix" data-bs-parent="#sipFaqAccordion">
                            <div class="accordion-body">Watch for guaranteed returns, urgent pressure to send funds, requests for your recovery phrase, unofficial apps or websites, and support agents who ask you to reveal private keys.</div>
                        </div>
                    </div>

                    <div class="accordion-item sip-faq-item">
                        <h2 class="accordion-header" id="sipHeadingSeven">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sipCollapseSeven" aria-expanded="false" aria-controls="sipCollapseSeven">
                                How can users reduce their own risk?
                            </button>
                        </h2>
                        <div id="sipCollapseSeven" class="accordion-collapse collapse" aria-labelledby="sipHeadingSeven" data-bs-parent="#sipFaqAccordion">
                            <div class="accordion-body">Use strong authentication, store recovery phrases offline, test with a small transaction first, keep software updated, and only use trusted devices and verified platform links.</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 sip-card">
                <h3 class="mb-2">Official notice</h3>
                <p class="mb-0">Cryptocurrency markets are volatile and may not be suitable for all users. Always review the risks before funding any account or initiating a transfer.</p>
            </div>
        </div>
    </section>
</main>
<?php include("footer.php"); ?>