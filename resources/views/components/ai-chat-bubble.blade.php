<style>
    .readify-chat-window {
        position: fixed;
        bottom: 92px;
        right: 24px;
        z-index: 999999;
        width: min(420px, calc(100vw - 32px));
        height: min(590px, 80vh);
        max-height: 80vh;
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.3);
        border: 1px solid #e5e7eb;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .readify-chat-toggle-wrap {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 999999;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .readify-chat-btn {
        width: 54px;
        height: 54px;
        border-radius: 9999px;
        background: linear-gradient(135deg, #004236 0%, #00705a 100%);
        color: #ffffff;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 12px 28px -5px rgba(0, 66, 54, 0.45);
        transition: all 0.2s ease;
        outline: none;
    }

    /* Mobile Sheet Mode & Position Above Mobile Bottom Nav */
    @media (max-width: 639px) {
        .readify-chat-toggle-wrap {
            bottom: 70px !important;
            right: 12px !important;
            gap: 0 !important;
        }

        .readify-chat-btn {
            width: 44px !important;
            height: 44px !important;
            box-shadow: 0 6px 18px -3px rgba(0, 66, 54, 0.35) !important;
            opacity: 0.88;
        }

        .readify-chat-btn:active,
        .readify-chat-btn:hover {
            opacity: 1 !important;
            transform: scale(1.05) !important;
        }

        .readify-chat-btn svg {
            width: 22px !important;
            height: 22px !important;
        }

        .readify-chat-window {
            bottom: 0 !important;
            left: 0 !important;
            right: 0 !important;
            width: 100vw !important;
            height: 88vh !important;
            max-height: 88vh !important;
            border-radius: 24px 24px 0 0 !important;
            border-bottom: none !important;
            border-left: none !important;
            border-right: none !important;
            box-shadow: 0 -10px 40px rgba(0, 0, 0, 0.25) !important;
        }
    }

    /* Pastikan saat display: none diterapkan Alpine, window benar-benar sembunyi */
    .readify-chat-window[style*="display: none"],
    .readify-chat-window[style*="display:none"] {
        display: none !important;
    }

    #readify-ai-messages {
        flex: 1 1 0% !important;
        min-height: 0 !important;
        height: 0 !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        overscroll-behavior: contain !important;
        -webkit-overflow-scrolling: touch !important;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f8fafc;
    }

    #readify-ai-messages::-webkit-scrollbar {
        width: 6px;
    }
    #readify-ai-messages::-webkit-scrollbar-track {
        background: #f8fafc;
    }
    #readify-ai-messages::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 9999px;
    }
    #readify-ai-messages::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>

<script>
    // Global Readify AI Chat Store & Component
    (function() {
        window.readifyAiChat = function() {
            return {
                isOpen: false,
                showGreeting: true,
                hasUnread: false,
                isLoading: false,
                userInput: '',
                messages: [],

                init() {
                    // Sembunyikan pill tooltip setelah 8 detik
                    setTimeout(() => {
                        this.showGreeting = false;
                    }, 8000);
                },

                toggleChat() {
                    this.isOpen = !this.isOpen;
                    if (this.isOpen) {
                        this.hasUnread = false;
                        this.showGreeting = false;
                        this.$nextTick(() => {
                            this.scrollToBottom();
                            if (this.$refs.chatInput) {
                                this.$refs.chatInput.focus();
                            }
                        });
                    }
                },

                closeChat() {
                    this.isOpen = false;
                },

                sendQuickPrompt(promptText) {
                    this.userInput = promptText;
                    this.sendMessage();
                },

                async sendMessage() {
                    const text = this.userInput.trim();
                    if (!text || this.isLoading) return;

                    // 1. Tampilkan pesan user di chat
                    this.messages.push({
                        role: 'user',
                        content: text
                    });
                    this.userInput = '';
                    this.isLoading = true;
                    this.scrollToBottom();

                    try {
                        // Ambil 6 riwayat terakhir untuk konteks dialog
                        const history = this.messages.slice(-6).map(m => ({
                            role: m.role,
                            content: m.content
                        }));

                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                        const response = await fetch('/api/ai/chat', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken || '',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                message: text,
                                history: history
                            })
                        });

                        const data = await response.json();

                        if (data && data.status === 'success' && data.reply) {
                            this.messages.push({
                                role: 'assistant',
                                content: data.reply,
                                books: data.books || []
                            });
                        } else {
                            this.messages.push({
                                role: 'assistant',
                                content: "Maaf, pustakawan AI sedang sibuk. Silakan coba tanyakan kembali seputar buku, lokasi rak, atau aturan perpustakaan Readify!"
                            });
                        }
                    } catch (err) {
                        console.error("AI Chat Error:", err);
                        this.messages.push({
                            role: 'assistant',
                            content: "Maaf, terjadi gangguan jaringan. Silakan tanyakan kembali beberapa saat lagi."
                        });
                    } finally {
                        this.isLoading = false;
                        this.scrollToBottom();
                    }
                },

                clearMessages() {
                    this.messages = [];
                    this.userInput = '';
                },

                scrollToBottom() {
                    this.$nextTick(() => {
                        const container = document.getElementById('readify-ai-messages');
                        if (container) {
                            container.scrollTop = container.scrollHeight;
                        }
                    });
                },

                formatMarkdown(content) {
                    if (!content) return '';
                    let escaped = content
                        .replace(/&/g, '&amp;')
                        .replace(/</g, '&lt;')
                        .replace(/>/g, '&gt;');

                    // Bold (**teks**)
                    escaped = escaped.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
                    // Italic (*teks*)
                    escaped = escaped.replace(/\*(.*?)\*/g, '<em>$1</em>');
                    // Bullet points (- atau •)
                    escaped = escaped.replace(/^\s*[-•]\s+(.*)$/gm, '<li style="margin-left: 1rem; list-style-type: disc;">$1</li>');
                    // Numbered lists (1. teks)
                    escaped = escaped.replace(/^\s*\d+\.\s+(.*)$/gm, '<li style="margin-left: 1rem; list-style-type: decimal;">$1</li>');
                    // Line breaks
                    escaped = escaped.replace(/\n/g, '<br>');

                    return escaped;
                }
            };
        };

        // Registrasi ke Alpine
        if (window.Alpine) {
            window.Alpine.data('readifyAiChat', window.readifyAiChat);
        } else {
            document.addEventListener('alpine:init', () => {
                if (window.Alpine) {
                    window.Alpine.data('readifyAiChat', window.readifyAiChat);
                }
            });
        }
    })();
</script>

<!-- READIFY AI LIBRARIAN CHAT BUBBLE -->
<div x-data="readifyAiChat()" class="font-sans" style="position: relative; z-index: 999999;">

    <!-- FLOATING TOGGLE BUTTON (BOTTOM RIGHT) -->
    <div class="readify-chat-toggle-wrap">
        
        <!-- Floating Prompt Tooltip Pill (Desktop Only) -->
        <div x-show="!isOpen && showGreeting"
            x-transition.opacity.duration.300ms
            class="hidden sm:flex"
            style="align-items: center; gap: 8px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(8px); padding: 8px 14px; border-radius: 9999px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15); border: 1px solid #d1fae5; font-size: 12px; font-weight: 600; color: #1f2937; cursor: pointer;"
            @click.stop="toggleChat()">
            <span style="display: inline-block; width: 8px; height: 8px; border-radius: 9999px; background-color: #10b981; animation: pulse 2s infinite;"></span>
            <span>{{ __('messages.ai_prompt_pill') }}</span>
            <button type="button" @click.stop="showGreeting = false" style="background: none; border: none; color: #9ca3af; cursor: pointer; padding: 0 2px; font-size: 14px; line-height: 1;" title="{{ __('messages.close') }}">×</button>
        </div>

        <!-- Main Circular Floating Button -->
        <button @click.stop="toggleChat()" type="button" aria-label="{{ __('messages.ai_prompt_pill') }}"
            class="readify-chat-btn">

            <!-- Icon Open State: X Mark -->
            <svg x-show="isOpen" style="width: 24px; height: 24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
            </svg>

            <!-- Icon Closed State: Book / Librarian -->
            <svg x-show="!isOpen" style="width: 24px; height: 24px; color: #a7f3d0;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
            </svg>
        </button>
    </div>

    <!-- CHAT POPUP WINDOW -->
    <div x-show="isOpen"
        x-transition.duration.200ms
        @keydown.escape.window="closeChat()"
        class="readify-chat-window"
        style="display: none;">

        <!-- HEADER -->
        <div style="padding: 14px 18px; background: linear-gradient(135deg, #004236 0%, #006e57 100%); color: #ffffff; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="position: relative; width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; border-radius: 14px; background: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.2); color: #a7f3d0;">
                    <svg style="width: 22px; height: 22px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                    <span style="position: absolute; bottom: -2px; right: -2px; width: 10px; height: 10px; border-radius: 9999px; background-color: #34d399; border: 2px solid #004236;"></span>
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <span style="font-size: 14px; font-weight: 700; letter-spacing: 0.02em;">{{ __('messages.ai_title') }}</span>
                        <span style="font-size: 10px; font-weight: 700; background: rgba(16, 185, 129, 0.35); color: #a7f3d0; padding: 1px 6px; border-radius: 9999px;">{{ __('messages.ai_librarian_badge') }}</span>
                    </div>
                    <p style="margin: 0; font-size: 11px; color: rgba(209, 250, 229, 0.85); display: flex; align-items: center; gap: 4px;">
                        <span style="display: inline-block; width: 6px; height: 6px; border-radius: 9999px; background-color: #34d399;"></span>
                        {{ __('messages.ai_online_status') }}
                    </p>
                </div>
            </div>

            <!-- Header Actions -->
            <div style="display: flex; align-items: center; gap: 6px;">
                <!-- Tombol Bersihkan Chat (Trash) -->
                <button type="button" @click.stop="clearMessages()" title="{{ __('messages.ai_clear_chat') }}" aria-label="{{ __('messages.ai_clear_chat') }}"
                    style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background: none; border: none; border-radius: 8px; color: rgba(255, 255, 255, 0.85); cursor: pointer; transition: background 0.15s ease;"
                    onmouseover="this.style.background='rgba(255,255,255,0.2)'; this.style.color='#ffffff';"
                    onmouseout="this.style.background='none'; this.style.color='rgba(255,255,255,0.85)';">
                    <svg style="width: 17px; height: 17px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>

                <!-- Tombol Tutup Window Chat (X) -->
                <button type="button" @click.stop="isOpen = false" title="{{ __('messages.ai_close_chat') }}" aria-label="{{ __('messages.ai_close_chat') }}"
                    style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background: none; border: none; border-radius: 8px; color: rgba(255, 255, 255, 0.85); cursor: pointer; transition: background 0.15s ease;"
                    onmouseover="this.style.background='rgba(255,255,255,0.2)'; this.style.color='#ffffff';"
                    onmouseout="this.style.background='none'; this.style.color='rgba(255,255,255,0.85)';">
                    <svg style="width: 20px; height: 20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- MESSAGES SCROLLABLE CONTAINER -->
        <div id="readify-ai-messages" style="background-color: #f9fafb; padding: 14px;">
            <div style="display: flex; flex-direction: column; gap: 14px; min-height: 100%;">

                <!-- Welcome Greeting Bubble -->
                <div style="display: flex; align-items: flex-start; gap: 10px;">
                    <div style="width: 32px; height: 32px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; border-radius: 10px; background-color: #004236; color: #ffffff; font-size: 11px; font-weight: 700; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        AI
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 8px; max-width: 86%;">
                        <div style="border-radius: 16px; border-top-left-radius: 4px; background: #ffffff; padding: 12px 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); border: 1px solid #f3f4f6; font-size: 12px; color: #1f2937; line-height: 1.55;">
                            {{ __('messages.ai_greeting') }}
                        </div>

                        <!-- Quick Suggestion Chips -->
                        <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                            <button type="button" @click="sendQuickPrompt('{{ __('messages.ai_quick_q1') }}')"
                                style="border-radius: 9999px; border: 1px solid #a7f3d0; background: #ecfdf5; padding: 5px 10px; font-size: 11px; font-weight: 600; color: #065f46; cursor: pointer; text-align: left; transition: all 0.15s ease;"
                                onmouseover="this.style.background='#d1fae5'"
                                onmouseout="this.style.background='#ecfdf5'">
                                {{ __('messages.ai_quick_q1') }}
                            </button>
                            <button type="button" @click="sendQuickPrompt('{{ __('messages.ai_quick_q2') }}')"
                                style="border-radius: 9999px; border: 1px solid #bfdbfe; background: #eff6ff; padding: 5px 10px; font-size: 11px; font-weight: 600; color: #1e40af; cursor: pointer; text-align: left; transition: all 0.15s ease;"
                                onmouseover="this.style.background='#dbeafe'"
                                onmouseout="this.style.background='#eff6ff'">
                                {{ __('messages.ai_quick_q2') }}
                            </button>
                            <button type="button" @click="sendQuickPrompt('{{ __('messages.ai_quick_q3') }}')"
                                style="border-radius: 9999px; border: 1px solid #fde68a; background: #fffbeb; padding: 5px 10px; font-size: 11px; font-weight: 600; color: #92400e; cursor: pointer; text-align: left; transition: all 0.15s ease;"
                                onmouseover="this.style.background='#fef3c7'"
                                onmouseout="this.style.background='#fffbeb'">
                                {{ __('messages.ai_quick_q3') }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Messages List -->
                <template x-for="(msg, index) in messages" :key="index">
                    <div>
                        <!-- USER MESSAGE -->
                        <template x-if="msg.role === 'user'">
                            <div style="display: flex; justify-content: flex-end; margin-bottom: 10px;">
                                <div style="border-radius: 16px; border-top-right-radius: 4px; background-color: #004236; padding: 10px 14px; font-size: 12px; color: #ffffff; max-width: 85%; box-shadow: 0 1px 3px rgba(0,0,0,0.1); line-height: 1.5; white-space: pre-wrap;"
                                    x-text="msg.content">
                                </div>
                            </div>
                        </template>

                        <!-- ASSISTANT (AI) MESSAGE -->
                        <template x-if="msg.role === 'assistant'">
                            <div style="display: flex; align-items: flex-start; gap: 10px; margin-bottom: 10px;">
                                <div style="width: 32px; height: 32px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; border-radius: 10px; background-color: #004236; color: #ffffff; font-size: 11px; font-weight: 700; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    AI
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 8px; max-width: 86%;">
                                    <!-- Text Bubble -->
                                    <div style="border-radius: 16px; border-top-left-radius: 4px; background: #ffffff; padding: 12px 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); border: 1px solid #f3f4f6; font-size: 12px; color: #1f2937; line-height: 1.55;"
                                        x-html="formatMarkdown(msg.content)">
                                    </div>

                                    <!-- Recommended Books Mini Cards -->
                                    <template x-if="msg.books && msg.books.length > 0">
                                        <div style="display: flex; flex-direction: column; gap: 6px; margin-top: 4px;">
                                            <span style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #6b7280;">Buku di Perpustakaan Readify:</span>
                                            <template x-for="buku in msg.books" :key="buku.id_buku">
                                                <div style="display: flex; align-items: center; gap: 10px; padding: 8px 10px; border-radius: 12px; background: #ffffff; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px rgba(0,0,0,0.04);">
                                                    <template x-if="buku.sampul">
                                                        <img :src="buku.sampul" alt="Cover" style="width: 34px; height: 48px; object-fit: cover; border-radius: 4px; box-shadow: 0 1px 2px rgba(0,0,0,0.1); flex-shrink: 0;">
                                                    </template>
                                                    <template x-if="!buku.sampul">
                                                        <div style="width: 34px; height: 48px; background: #f3f4f6; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #9ca3af; flex-shrink: 0;">
                                                            <svg style="width: 18px; height: 18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                            </svg>
                                                        </div>
                                                    </template>
                                                    <div style="flex: 1; min-width: 0;">
                                                        <div style="font-size: 12px; font-weight: 700; color: #111827; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" x-text="buku.judul_buku"></div>
                                                        <div style="font-size: 10px; color: #6b7280; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" x-text="'Oleh: ' + buku.penulis"></div>
                                                        <div style="display: flex; align-items: center; gap: 6px; font-size: 10px; font-weight: 600; color: #047857; margin-top: 2px;">
                                                            <span x-text="buku.lokasi_rak || 'Rak Koleksi'"></span>
                                                            <span>•</span>
                                                            <span x-text="'Stok: ' + buku.stok + ' eks'"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>

                <!-- Typing Indicator Animation -->
                <div x-show="isLoading" style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 32px; height: 32px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; border-radius: 10px; background-color: #004236; color: #ffffff; font-size: 11px; font-weight: 700;">
                        AI
                    </div>
                    <div style="border-radius: 16px; border-top-left-radius: 4px; background: #ffffff; padding: 10px 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); border: 1px solid #f3f4f6; display: flex; align-items: center; gap: 5px;">
                        <span style="display: inline-block; width: 6px; height: 6px; border-radius: 9999px; background-color: #059669; animation: bounce 1s infinite;"></span>
                        <span style="display: inline-block; width: 6px; height: 6px; border-radius: 9999px; background-color: #059669; animation: bounce 1s infinite 0.2s;"></span>
                        <span style="display: inline-block; width: 6px; height: 6px; border-radius: 9999px; background-color: #059669; animation: bounce 1s infinite 0.4s;"></span>
                    </div>
                </div>

            </div>
        </div>

        <!-- INPUT FORM -->
        <div style="padding: 10px 14px; background: #ffffff; border-top: 1px solid #f3f4f6; flex-shrink: 0;">
            <form @submit.prevent="sendMessage()" style="display: flex; align-items: center; gap: 8px; margin: 0;">
                <input type="text" x-model="userInput" x-ref="chatInput"
                    placeholder="{{ __('messages.ai_input_placeholder') }}"
                    :disabled="isLoading"
                    style="flex: 1; border-radius: 14px; border: 1px solid #e5e7eb; background: #f9fafb; padding: 9px 14px; font-size: 12px; color: #111827; outline: none; transition: all 0.2s ease;"
                    onfocus="this.style.background='#ffffff'; this.style.borderColor='#004236';"
                    onblur="this.style.background='#f9fafb'; this.style.borderColor='#e5e7eb';">

                <button type="submit" :disabled="isLoading || !userInput.trim()"
                    style="width: 36px; height: 36px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; border-radius: 12px; background-color: #004236; color: #ffffff; border: none; cursor: pointer; transition: all 0.2s ease; outline: none;"
                    onmouseover="this.style.background='#00332a'"
                    onmouseout="this.style.background='#004236'">
                    <svg style="width: 16px; height: 16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>
            </form>
            <p style="margin: 6px 0 0 0; font-size: 10px; text-align: center; color: #9ca3af;">
                {{ __('messages.ai_librarian_badge') }} • Readify AI Assistant
            </p>
        </div>

    </div>

</div>
