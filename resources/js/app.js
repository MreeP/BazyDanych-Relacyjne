import './bootstrap';
import { Alpine, Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm';
import SlideIn from "./alpine/slide-in.js";
import Notification from "./alpine/notification.js";

Alpine.data('slidein', SlideIn);
Alpine.data('notification', Notification);

Livewire.start();
